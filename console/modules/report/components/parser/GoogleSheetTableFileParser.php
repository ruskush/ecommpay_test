<?php

namespace console\modules\report\components\parser;

use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class GoogleSheetTableFileParser extends TableFileParser {

    /**
     * @inheritdoc
     */
    protected function getTableReader(): IReader {
        return new Xlsx();
    }
}