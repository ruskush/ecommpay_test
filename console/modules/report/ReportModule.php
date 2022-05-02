<?php

namespace console\modules\report;

use common\components\GoogleDriveFilesystem;
use console\modules\report\components\dbService\DbSaverService;
use console\modules\report\components\dbService\SaverServiceInterface;
use console\modules\report\components\file\FileProcessorFabric;
use console\modules\report\components\fileService\FileService;
use console\modules\report\components\fileService\FileServiceInterface;
use creocoder\flysystem\LocalFilesystem;
use Yii;
use yii\base\BootstrapInterface;

/**
 * @property GoogleDriveFilesystem $googleDrive
 */
class ReportModule extends \yii\base\Module implements BootstrapInterface {
    public $controllerNamespace = 'console\modules\report\controllers';

    /**
     * @var string Корневая директория для директорий upload, archive, invalid
     */
    public string $storagePath = '';

    /**
     * @var string Директория, в которую происходи скачивание файлов. Путь указывается  относительно корневой директории,
     * заданной в [[storagePath]].
     */
    public string $uploadDir = 'upload';

    /**
     * @var string Директория, в которую перемещаются удачно спаршенные и сохранённые в БД файлы. Путь указывается
     * относительно корневой директории, заданной в [[storagePath]].
     */
    public string $archiveDir = 'archive';

    /**
     * @var string Директория, в которую перемещаются файлы, которые не удалось спарсить либо сохранить в БД. Путь
     * указывается относительно корневой директории, заданной в [[storagePath]].
     */
    public string $invalidDir = 'invalid';

    /**
     * @var string Имя компонента подключения к БД
     */
    public string $dbComponent;

    public function bootstrap($app) {
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'console\modules\report\controllers';
            Yii::$container->set(FileServiceInterface::class, [
                'class' => FileService::class,
                'remoteFs' => ['class' => GoogleDriveFilesystem::class],
                'localFs' => ['class' => LocalFilesystem::class],
                'fabric' => ['class' => FileProcessorFabric::class],
                'uploadPath' => $this->uploadDir,
                'archivePath' => $this->archiveDir,
                'invalidPath' => $this->invalidDir,
            ]);
            Yii::$container->set(SaverServiceInterface::class, [
                'class' => DbSaverService::class,
                'db' => Yii::$app->get($this->dbComponent),
            ]);
            Yii::$container->set(GoogleDriveFilesystem::class, [
                'authConfigFile' => Yii::getAlias('@base/auth_config.json'),
                'rootFolderId' => '1VBbPPZLBYppo0RHyXcJ2dl9uaWZPGirS',
            ]);
            Yii::$container->set(LocalFilesystem::class, [
                'path' => $this->storagePath,
            ]);
        }
    }
}