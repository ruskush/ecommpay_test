<?php

namespace console\modules\report\traits;

use yii\db\ActiveRecordInterface;

/**
 * Trait FindOrCreate
 * @package common\traits
 */
trait FindOrCreateTrait {
    /**
     * Если с заданным условием $condition найдена запись в БД - возвращается её модель.
     * Если запись не найдена - создаётся новая, возвращается модель созданной записи.
     * @param array $condition массив в виде ['column' => $value] для поиска либо создания модели
     * @return bool|self
     */
    public static function findOrCreate(array $condition): ActiveRecordInterface {
        if (($model = self::findOne($condition)) === null) {
            $model = new self();
            foreach ($condition as $column => $value) {
                $model->$column = $value;
            }
            $model->save();
        }
        return $model;
    }
}
