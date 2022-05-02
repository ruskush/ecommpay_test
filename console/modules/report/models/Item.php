<?php

namespace console\modules\report\models;

use console\modules\report\traits\FindOrCreateTrait;
use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $name
 *
 * @property Order[] $orders
 */
class Item extends BaseAr {
    use FindOrCreateTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders() {
        return $this->hasMany(Order::className(), ['item_id' => 'id']);
    }
}
