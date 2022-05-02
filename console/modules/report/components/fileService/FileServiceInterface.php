<?php

namespace console\modules\report\components\fileService;

use console\modules\report\components\file\FileDto;

interface FileServiceInterface {
    public function uploadAll();

    public function getUploadedFiles(): array;

    public function moveToArchive(FileDto $file);

    public function moveToInvalid(FileDto $file);

    public function getLocalFsRoot(): string;
}