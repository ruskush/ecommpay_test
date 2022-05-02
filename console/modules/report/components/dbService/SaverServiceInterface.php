<?php

namespace console\modules\report\components\dbService;

use DateTime;

/**
 * Интерфейс сервиса, который производит сохранение данных. Этот интерфейс можно использовать для реализации сервисов
 * с различными технологиями сохранения данных (БД, файлы, облако и т.д.)
 */
interface SaverServiceInterface {
    /**
     * Метод сохраняет данные файла-отчёта.
     * @param array $data Данные из файла.
     * @param DateTime $reportDate Дата отчёта
     * @param string $partnerName Название партнёра
     * @return void
     */
    public function saveReport(array $data, DateTime $reportDate, string $partnerName);
}