<?php

namespace console\modules\report\components\constant;

class DeliveryType {
    const COURIER = 'courier';
    const PICK_UP = 'pick_up';
    const ALL_TYPES = [self::COURIER, self::PICK_UP];

    const LABELS = [
        self::COURIER => 'Курьер',
        self::PICK_UP => 'Самовывоз',
    ];
    const ALL_LABELS = ['Курьер', 'Самовывоз'];
}