<?php

namespace console\modules\report\models;

use console\modules\report\traits\FindOrCreateTrait;
use Yii;

/**
 * This is the model class for table "partner".
 *
 * @property int $id
 * @property string $name
 *
 * @property Order[] $orders
 * @property Report[] $reports
 */
class Partner extends BaseAr {
    use FindOrCreateTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'partner';
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
        return $this->hasMany(Order::className(), ['report_id' => 'id']);
    }

    /**
     * Gets query for [[Reports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReports() {
        return $this->hasMany(Report::className(), ['partner_id' => 'id']);
    }
}
