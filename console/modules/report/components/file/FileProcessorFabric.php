<?php

namespace console\modules\report\components\file;

class FileProcessorFabric {
    /**
     * В зависимости от типа файла, переданного в fileDto
     * Метод возвращает соответствующий класс-обработчик для работы с разными форматами файла. Формат файла определяется
     * по данным, переданным в аргументе $fileDto
     */
    public function getProcessor(FileDto $fileDto): FileProcessorInterface {
        if ($fileDto->mimetype === 'application/vnd.google-apps.spreadsheet' || $fileDto->extension === 'xls' || $fileDto->extension === 'xlsx') {
            return new GoogleSheetFileProcessor();
        } elseif ($fileDto->mimetype === 'text/csv' || $fileDto->extension === 'csv') {
            return new CsvFileProcessor();
        } else {
            throw new \Exception('Unknown format of file: ' . $fileDto->path);
        }
    }
}