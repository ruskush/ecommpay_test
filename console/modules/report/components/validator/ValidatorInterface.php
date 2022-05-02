<?php

namespace console\modules\report\components\validator;

/**
 * Интерфейс валидатора структуры файла.
 */
interface ValidatorInterface {
    /**
     * Метод принимает одной запись (строку) файла в виде массива пар key => value, где  key - название колонки,
     * value - данные в этой колонке.
     * @param array $row
     * @return bool Если переданная запись $row - валидна - возвращается true, иначе - false
     */
    public function isValid(array $row): bool;
}