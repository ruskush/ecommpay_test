<?php

namespace console\modules\report\components\validator;

use console\modules\report\components\constant\DeliveryType;
use yii\base\DynamicModel;
use yii\helpers\VarDumper;

class RowValidator implements ValidatorInterface {

    /**
     * @inheritdoc
     */
    public function isValid(array $row): bool {
        $model = DynamicModel::validateData($row, [
            [['client_name', 'item_name', 'city_name', 'order_at', 'count', 'cost', 'price'], 'required'],
            [['order_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['client_name', 'item_name', 'city_name'], 'string', 'max' => 255],
            [['count'], 'integer', 'min' => 0],
            [['delivery_type'], 'in', 'range' => DeliveryType::ALL_LABELS],
            [['cost', 'delivery_cost_pick_up', 'price'], 'number', 'min' => 0],
        ]);
        if ($model->hasErrors()) {
            VarDumper::dump($model->errors);
            echo PHP_EOL;
            return false;
        }
        return true;
    }
}