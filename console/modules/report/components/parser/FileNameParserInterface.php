<?php

namespace console\modules\report\components\parser;

use DateTime;

/**
 * Интерфейс парсера имени файла. Для каждого паттерна имени файла должен быть создан отдельный класс, реализующий
 * данный интерфейс.
 */
interface FileNameParserInterface {

    /**
     * @return bool Имя файла соответсвует паттерну, компоненты (Партнёр и дата) могут быть извлечены.
     */
    public function isValid(): bool;

    /**
     * @return string Извлечённое имя Партнёра. Когда [[isValid()]] возвращает false - этот метод должен возвращать
     * пустую строку.
     */
    public function getPartnerName(): string;

    /**
     * @return DateTime|null Извлечённая дата. Когда [[isValid()]] возвращает false - этот метод должен возвращать null.
     */
    public function getDate(): ?DateTime;
}