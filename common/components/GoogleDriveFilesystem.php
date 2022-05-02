<?php

namespace common\components;

use creocoder\flysystem\Filesystem;
use Google\Service\Drive;
use Google_Client;
use Google_Service_Drive;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use League\Flysystem\AdapterInterface;
use yii\base\InvalidConfigException;

class GoogleDriveFilesystem extends Filesystem {
    /**
     * @var string|null Путь к файлу с конфигурацией подключения к GoogleDrive
     */
    public ?string $authConfigFile = null;

    /**
     * @var string|null ID корневого каталога в GoogleDrive, из которого будет производится скачивание отчётов
     */
    public ?string $rootFolderId = null;

    /**
     * @inheritdoc
     */
    public function init() {
        if ($this->authConfigFile === null) {
            throw new InvalidConfigException('The "authConfigFile" property must be set.');
        }
        parent::init();
    }

    /**
     * @return AdapterInterface
     */
    protected function prepareAdapter() {
        $client = new Google_Client();
        $client->addScope(Drive::DRIVE);
        $client->setAuthConfig($this->authConfigFile);
        $service = new Google_Service_Drive($client);
        return new GoogleDriveAdapter($service, $this->rootFolderId); // Dossier chantier
    }
}