<?php

namespace console\modules\report\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $order_at Дата и время заказа
 * @property int $report_id Отчёт
 * @property int $client_id Клиент
 * @property int $item_id Товар/услуга
 * @property int $count  Количество
 * @property float $cost Стоимость за единицу
 * @property string|null $delivery_type Тип доставки (курьер/самовывоз)
 * @property int $city_id Город доставки
 * @property float|null $delivery_cost_pick_up Сстоимость доставки курьером
 * @property float $price Итого стоимость
 *
 * @property City $city
 * @property Client $client
 * @property Item $item
 * @property Partner $report
 */
class Order extends BaseAr {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['order_at', 'report_id', 'client_id', 'item_id', 'count', 'cost', 'city_id', 'price'], 'required'],
            [['order_at'], 'safe'],
            [['report_id', 'client_id', 'item_id', 'count', 'city_id'], 'integer'],
            [['cost', 'delivery_cost_pick_up', 'price'], 'number'],
            [['delivery_type'], 'string'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['report_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partner::className(), 'targetAttribute' => ['report_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'order_at' => 'Order At',
            'report_id' => 'Report ID',
            'client_id' => 'Client ID',
            'item_id' => 'Item ID',
            'count' => 'Count',
            'cost' => 'Cost',
            'delivery_type' => 'Delivery Type',
            'city_id' => 'City ID',
            'delivery_cost_pick_up' => 'Delivery Cost Pick Up',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity() {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient() {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem() {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    /**
     * Gets query for [[Report]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReport() {
        return $this->hasOne(Partner::className(), ['id' => 'report_id']);
    }
}
