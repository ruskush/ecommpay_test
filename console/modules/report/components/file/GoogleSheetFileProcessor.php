<?php

namespace console\modules\report\components\file;

use console\modules\report\components\parser\FileParserInterface;
use console\modules\report\components\parser\GoogleSheetTableFileParser;
use console\modules\report\components\validator\ValidatorInterface;

class GoogleSheetFileProcessor implements FileProcessorInterface {

    /**
     * @inheritdoc
     */
    public function getExportFileName(FileDto $fileDto): string {
        return $fileDto->name . '.xlsx';
    }

    /**
     * @inheritdoc
     */
    public function buildFileParser(string $filepath, ValidatorInterface $validator): FileParserInterface {
        return new GoogleSheetTableFileParser($filepath, $validator);
    }
}