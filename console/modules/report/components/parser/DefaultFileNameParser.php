<?php

namespace console\modules\report\components\parser;

use DateTime;

class DefaultFileNameParser implements FileNameParserInterface {

    private string $partnerName = '';
    private ?DateTime $date = null;
    private bool $parsed = false;
    private string $filename = '';

    /**
     * @param string $filename Имя файла, которое необходимо парсить.
     */
    public function __construct(string $filename) {
        $this->filename = $filename;
    }

    /**
     * @inheritdoc
     */
    public function isValid(): bool {
        $this->parse();
        return $this->partnerName !== '' && $this->date instanceof DateTime;
    }

    /**
     * @inheritdoc
     */
    public function getPartnerName(): string {
        $this->parse();
        return $this->partnerName;
    }

    /**
     * @inheritdoc
     */
    public function getDate(): ?DateTime {
        $this->parse();
        return $this->date;
    }

    /**
     * Парсинг строки [[filename]].
     * @return void
     */
    private function parse() {
        if ($this->parsed === false) {
            $pattern = "/^[A-Za-z\d,'\"]+_\d{1,2}\.\d{1,2}\.\d{2,4}./";
            if (preg_match($pattern, $this->filename, $match) === 1) {
                [$this->partnerName, $dateStr] = explode('_', $match[0]);
                $dateStr = trim($dateStr, '.');
                $dateTime = DateTime::createFromFormat('d.m.Y', $dateStr);
                $this->date = $dateTime !== false ? $dateTime : null;
            }
        }
        $this->parsed = true;
    }
}