<?php

namespace console\modules\report\components\parser;

interface FileParserInterface {
    /**
     * @return bool Возвращает true, если структура всего файла корректна, иначе - false.
     */
    public function isValid(): bool;

    /**
     * @return ParsedRowDto[] Массив строк (записей) спаршенного файла. Строка (запись) представлена в виде массива
     * пар key => value, где  key - название колонки, value - данные в этой колонке. Если структура файла некорректна
     * (isValid() === true) - то метод должен возвратить пустой массив.
     */
    public function getContent(): array;
}