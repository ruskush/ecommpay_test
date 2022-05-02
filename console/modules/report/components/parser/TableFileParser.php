<?php

namespace console\modules\report\components\parser;

use console\modules\report\components\validator\ValidatorInterface;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\Shared\Date;

/**
 * Абстрактный класс для парсинга файлов в "табличных" форматах. Для парсинга используется библиотека
 * phpoffice/phpspreadsheet, которая может работать с форматами xls, xlsx, csv, ods, html, xml и т.д.
 * Для реализации парсера для конкретного формата нужно расширить этот класс и переопределиьт абстрактный
 * метод getTableReader(), который должен возвратить соответствующий формату файла экземпляр объекта, реализующий
 * интерфейс PhpOffice\PhpSpreadsheet\Reader\IReader.
 */
abstract class TableFileParser implements FileParserInterface {

    protected string $filepath;
    private array $data = [];
    private bool $parsed = false;
    private ValidatorInterface $validator;

    /**
     * @var array Ключи массива - буквенный индекс колонки, значение - название колонки, которое будет использоваться
     * при формировании массива строки (записи) файла.
     */
    protected array $columnMap = [
        'A' => 'order_at',
        'B' => 'client_name',
        'C' => 'item_name',
        'D' => 'count',
        'E' => 'cost',
        'F' => 'delivery_type',
        'G' => 'city_name',
        'H' => 'delivery_cost_pick_up',
        'I' => 'price',
    ];

    /**
     * @var int Номер строки, с которой начинаются данные в таблице (всё что выше - не парсится).
     */
    protected int $rowDataBeginning = 2;

    /**
     * @param string $filepath Абсолютный путь к файлу для парсинга.
     * @param ValidatorInterface $validator Валидатор структуры файла
     */
    public function __construct(string $filepath, ValidatorInterface $validator) {
        $this->filepath = $filepath;
        $this->validator = $validator;
    }

    /**
     * @inheritdoc
     */
    public function getContent(): array {
        $this->parseWithCache();
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function isValid(): bool {
        $this->parseWithCache();

        if (!empty($this->data)) {
            $hasError = false;
            foreach ($this->data as $row) {
                if (!$this->validator->isValid((array)$row)) {
                    $hasError = true;
                }
            }
            return !$hasError;
        } else {
            return false;
        }
    }

    /**
     * @return IReader Экземпляр ридера файла
     */
    abstract protected function getTableReader(): IReader;

    private function parseWithCache(): array {
        if (!$this->parsed) {
            $this->data = $this->parse();
        }
        return $this->data;
    }

    private function parse(): array {
        $reader = $this->getTableReader();
        $spreadsheet = $reader->load($this->filepath);
        $cells = $spreadsheet->getActiveSheet();
        $highestColumn = $cells->getHighestDataColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        $result = [];

        for ($row = $this->rowDataBeginning; $row <= $cells->getHighestDataRow(); $row++) {
            $resultRow = [];
            for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                if ($cells && ($cell = $cells->getCellByColumnAndRow($col, $row))) {
                    if (Date::isDateTime($cell)) {
                        $value = str_replace('/', '.', $cell->getFormattedValue());
                    } else {
                        $value = $cell->getValue();
                    }
                    $colName = $this->columnMap[Coordinate::stringFromColumnIndex($col)] ?? Coordinate::stringFromColumnIndex($col);
                    $resultRow[$colName] = (string)$value;
                }
            }
            $result[] = new ParsedRowDto($resultRow);
        }
        $this->parsed = true;
        return $result;
    }
}