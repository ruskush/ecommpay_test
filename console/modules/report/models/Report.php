<?php

namespace console\modules\report\models;

use console\modules\report\traits\FindOrCreateTrait;
use Yii;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property string $report_at
 * @property int $partner_id
 *
 * @property Partner $partner
 */
class Report extends BaseAr {
    use FindOrCreateTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['report_at', 'partner_id'], 'required'],
            [['report_at'], 'safe'],
            [['partner_id'], 'integer'],
            [['partner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partner::className(), 'targetAttribute' => ['partner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'report_at' => 'Report At',
            'partner_id' => 'Partner ID',
        ];
    }

    /**
     * Gets query for [[Partner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPartner() {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }
}
