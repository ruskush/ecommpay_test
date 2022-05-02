<?php

namespace console\modules\report\models;

use Yii;
use yii\db\Connection;
use yii\db\Exception;

/**
 * Базовый класс для всех ActiveRecord моделей этого модуля.
 */
abstract class BaseAr extends \yii\db\ActiveRecord {

    public static function getDb() {
        if (($db = Yii::$app->get(Yii::$app->controller->module->dbComponent)) instanceof Connection) {
            return $db;
        }
        throw new Exception('Bad connection component name');
    }
}