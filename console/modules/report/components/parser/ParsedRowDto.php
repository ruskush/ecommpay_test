<?php

namespace console\modules\report\components\parser;

class ParsedRowDto {
    public $order_at;
    public $client_name;
    public $item_name;
    public $count;
    public $cost;
    public $delivery_type;
    public $city_name;
    public $delivery_cost_pick_up;
    public $price;

    public function __construct(array $params) {
        $this->order_at = $params['order_at'] ?? null;
        $this->client_name = $params['client_name'] ?? null;
        $this->item_name = $params['item_name'] ?? null;
        $this->count = $params['count'] ?? null;
        $this->cost = $params['cost'] ?? null;
        $this->delivery_type = $params['delivery_type'] ?? null;
        $this->city_name = $params['city_name'] ?? null;
        $this->delivery_cost_pick_up = $params['delivery_cost_pick_up'] ?? null;
        $this->price = $params['price'] ?? null;
    }
}