<?php

namespace console\modules\report\components\parser;

use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\IReader;

class CsvTableFileParser extends TableFileParser {

    /**
     * @inheritdoc
     */
    protected function getTableReader(): IReader {
        return new Csv();
    }
}