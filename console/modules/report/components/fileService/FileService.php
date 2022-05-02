<?php

namespace console\modules\report\components\fileService;

use common\components\GoogleDriveFilesystem;
use console\modules\report\components\file\FileDto;
use console\modules\report\components\file\FileProcessorFabric;
use creocoder\flysystem\LocalFilesystem;

class FileService extends \yii\base\BaseObject implements FileServiceInterface {

    /**
     * @var GoogleDriveFilesystem Компонент файловой системы для работы с файлами на сервисе Google Drive
     */
    public $remoteFs;

    /**
     * @var LocalFilesystem Компонент локальной файловой системы
     */
    public $localFs;

    /**
     * @var FileProcessorFabric
     */
    public $fabric;

    /**
     * @var string Директория, в которую происходи скачивание файлов. Путь указывается  относительно корневой директории,
     * заданной в [[localFs]].
     */
    public string $uploadPath = '';

    /**
     * @var string Директория, в которую перемещаются удачно спаршенные и сохранённые в БД файлы. Путь указывается
     * относительно корневой директории, заданной в [[localFs]].
     */
    public string $archivePath = '';

    /**
     * @var string Директория, в которую перемещаются файлы, которые не удалось спарсить либо сохранить в БД. Путь
     * указывается относительно корневой директории, заданной в [[localFs]].
     */
    public string $invalidPath = '';

    public function __construct(GoogleDriveFilesystem $remoteFs, LocalFilesystem $localFs, FileProcessorFabric $fabric, $config = []) {
        parent::__construct($config);
        $this->remoteFs = $remoteFs;
        $this->localFs = $localFs;
        $this->fabric = $fabric;
    }

    /**
     * Метод скачивает (переносит) файлы из корневой директории GoogleDrive, указанной в [[remoteFs]], в локальную
     * директорию [[uploadPath]].
     * @return void
     * @throws \Exception
     */
    public function uploadAll() {
        $remoteFiles = $this->remoteFs->listContents();
        foreach ($remoteFiles as $remoteFile) {
            $fileDto = new FileDto($remoteFile);
            $fileProcessor = $this->fabric->getProcessor($fileDto);

            $uploadFilePath = $this->uploadPath . '/' . $fileProcessor->getExportFileName($fileDto);
            $downloadFilePath = $fileDto->dirname . '/' . $fileDto->basename;

            if (!$this->localFs->has($uploadFilePath)) {
                $stream = $this->remoteFs->readStream($downloadFilePath);
                $content = stream_get_contents($stream);
                fclose($stream);
                $this->localFs->write($uploadFilePath, $content);
            }
//            $this->remoteFs->delete($downloadFilePath);
        }
    }

    /**
     * @return FileDto[] Возвращает массив с данными о файах в директории [[uploadPath]]
     */
    public function getUploadedFiles(): array {
        $result = [];
        $files = $this->localFs->listContents($this->uploadPath);
        foreach ($files as $file) {
            $result[] = new FileDto($file);
        }
        return $result;
    }

    /**
     * Перемещение файла из директории [[uploadPath]] в [[archivePath]]
     * @param FileDto $file
     * @return void
     */
    public function moveToArchive(FileDto $file) {
        $archiveFilePath = $this->archivePath . '/' . $file->basename;
        $this->moveFile($file->path, $archiveFilePath);
    }

    /**
     * Перемещение файла из директории [[uploadPath]] в [[invalidPath]]
     * @param FileDto $file
     * @return void
     */
    public function moveToInvalid(FileDto $file) {
        $invalidFilePath = $this->invalidPath . '/' . $file->basename;
        $this->moveFile($file->path, $invalidFilePath);
    }

    /**
     * @return string Корень локальной файловой системы компонента [[localFs]]
     */
    public function getLocalFsRoot(): string {
        return $this->localFs->path;
    }

    /**
     * Перемещение файла из одной директории в другую (в компоненте локальной файловой системы [[localFs]])
     * @param string $fromPath
     * @param string $toPath
     * @return void
     */
    private function moveFile(string $fromPath, string $toPath) {
        $filesystem = $this->localFs;
        if ($filesystem->has($fromPath)) {
            $content = $filesystem->readAndDelete($fromPath);
            if (!$filesystem->has($toPath)) {
                $filesystem->write($toPath, $content);
            }
        }
    }
}