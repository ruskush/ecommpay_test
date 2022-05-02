<?php

namespace console\modules\report\components\file;


use console\modules\report\components\parser\FileParserInterface;
use console\modules\report\components\validator\ValidatorInterface;

interface FileProcessorInterface {
    /**
     * Метод формирует имя файла, скачанного из GoogleDrive. Алгоритм формирования имени файла может отличаться у разных
     * форматов файлов. Например, при экспорте онлайн-таблиц GoogleSheet АПИ возвращает только имя файла, без расширения,
     * в то время как загруженные на GoogleDrive файлы сохраняют своё расширение.
     * @param FileDto $fileDto
     * @return string
     */
    public function getExportFileName(FileDto $fileDto): string;

    /**
     * Метод настраивает и возвращает объект - парсер файла.
     * @param string $filepath абсолютный путь к файлу для парсинга.
     * @param ValidatorInterface $validator Валидатор структуры файла.
     * @return FileParserInterface
     */
    public function buildFileParser(string $filepath, ValidatorInterface $validator): FileParserInterface;
}