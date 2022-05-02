<?php

namespace console\modules\report\controllers;

use console\modules\report\components\dbService\SaverServiceInterface;
use console\modules\report\components\file\FileDto;
use console\modules\report\components\fileService\FileServiceInterface;
use console\modules\report\components\parser\DefaultFileNameParser;
use console\modules\report\components\validator\RowValidator;

class DefaultController extends \yii\console\Controller {
    private FileServiceInterface $fileService;
    private SaverServiceInterface $dbService;

    public function __construct($id, $module, FileServiceInterface $fileService, SaverServiceInterface $dbService, $config = []) {
        $this->fileService = $fileService;
        $this->dbService = $dbService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex() {
        $fileService = $this->fileService;
        $fabric = $fileService->fabric;
        $dbService = $this->dbService;

        $fileService->uploadAll();
        /** @var FileDto[] $files */
        $files = $fileService->getUploadedFiles();
        foreach ($files as $file) {
            $fileName = new DefaultFileNameParser($file->filename);
            if (!$fileName->isValid()) {
                $fileService->moveToInvalid($file);
                continue;
            }
            $fileProcessor = $fabric->getProcessor($file);
            $filePath = $fileService->getLocalFsRoot() . '/' . $file->path;
            $fileParser = $fileProcessor->buildFileParser($filePath, new RowValidator());

            if (!$fileParser->isValid()) {
                $fileService->moveToInvalid($file);
                continue;
            }
            try {
                $dbService->saveReport($fileParser->getContent(), $fileName->getDate(), $fileName->getPartnerName());
            } catch (\Throwable $ex) {
                $fileService->moveToInvalid($file);
                echo $ex->getMessage() . PHP_EOL;
            }
            $fileService->moveToArchive($file);

        }
    }
}