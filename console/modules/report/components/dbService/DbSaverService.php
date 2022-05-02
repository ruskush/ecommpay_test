<?php

namespace console\modules\report\components\dbService;

use console\modules\report\components\constant\DeliveryType;
use console\modules\report\models\City;
use console\modules\report\models\Client;
use console\modules\report\models\Item;
use console\modules\report\models\Order;
use console\modules\report\models\Partner;
use console\modules\report\models\Report;
use yii\base\BaseObject;
use yii\db\Connection;

/**
 * Сервис реализует сохранение отчётов в БД.
 */
class DbSaverService extends BaseObject implements SaverServiceInterface {

    /**
     * @var Connection Компонент подключения к БД.
     */
    public Connection $db;

    /**
     * @inheritdoc
     */
    public function saveReport(array $data, \DateTime $reportDate, string $partnerName): void {
        $deliveryTypes = array_flip(DeliveryType::LABELS);
        $db = $this->db;
        $transaction = $db->beginTransaction();
        try {
            $partner = Partner::findOrCreate(['name' => $partnerName]);
            $report = Report::findOrCreate(['partner_id' => $partner->id, 'report_at' => $reportDate->format('Y-m-d')]);

            foreach ($data as $rowDto) {
                $city = City::findOrCreate(['name' => $rowDto->city_name]);
                $client = Client::findOrCreate(['name' => $rowDto->client_name]);
                $item = Item::findOrCreate(['name' => $rowDto->item_name]);

                $order = new Order();
                $rowDto->delivery_type = $deliveryTypes[$rowDto->delivery_type];
                $order->load((array)$rowDto, '');
                $order->report_id = $report->id;
                $order->city_id = $city->id;
                $order->client_id = $client->id;
                $order->item_id = $item->id;
                $order->save(false);
            }
            $transaction->commit();
        } catch (\Throwable $exception) {
            $transaction->rollBack();
            throw $exception;
        }
    }
}