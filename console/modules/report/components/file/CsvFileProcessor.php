<?php

namespace console\modules\report\components\file;


use console\modules\report\components\parser\CsvTableFileParser;
use console\modules\report\components\parser\FileParserInterface;
use console\modules\report\components\validator\ValidatorInterface;

class CsvFileProcessor implements FileProcessorInterface {

    /**
     * @inheritdoc
     */
    public function getExportFileName(FileDto $fileDto): string {
        return $fileDto->filename . '.csv';
    }

    /**
     * @inheritdoc
     */
    public function buildFileParser(string $filepath, ValidatorInterface $validator): FileParserInterface {
        return new CsvTableFileParser($filepath, $validator);
    }
}