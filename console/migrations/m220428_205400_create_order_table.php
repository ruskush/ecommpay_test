<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%client}}`
 * - `{{%item}}`
 * - `{{%city}}`
 */
class m220428_205400_create_order_table extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'order_at' => $this->datetime()->notNull()->comment('Дата и время заказа'),
            'report_id' => $this->integer()->notNull()->comment('Отчёт'),
            'client_id' => $this->integer()->notNull()->comment('Клиент'),
            'item_id' => $this->integer()->notNull()->comment('Товар/услуга'),
            'count' => $this->integer()->notNull()->comment(' Количество'),
            'cost' => $this->decimal(11, 2)->notNull()->comment('Стоимость за единицу'),
            'delivery_type' => "enum('courier', 'pick_up') comment 'Тип доставки (курьер/самовывоз)'",
            'city_id' => $this->integer()->notNull()->comment('Город доставки'),
            'delivery_cost_pick_up' => $this->decimal(11, 2)->null()->comment('Сстоимость доставки курьером'),
            'price' => $this->decimal(11, 2)->notNull()->comment('Итого стоимость'),
        ]);

        // creates index for column `report_id`
        $this->createIndex(
            '{{%idx-order-report_id}}',
            '{{%order}}',
            'report_id'
        );

        // add foreign key for table `{{%partner}}`
        $this->addForeignKey(
            '{{%fk-order-report_id}}',
            '{{%order}}',
            'report_id',
            '{{%partner}}',
            'id',
            'CASCADE'
        );

        // creates index for column `client_id`
        $this->createIndex(
            '{{%idx-order-client_id}}',
            '{{%order}}',
            'client_id'
        );

        // add foreign key for table `{{%client}}`
        $this->addForeignKey(
            '{{%fk-order-client_id}}',
            '{{%order}}',
            'client_id',
            '{{%client}}',
            'id',
            'CASCADE'
        );

        // creates index for column `item_id`
        $this->createIndex(
            '{{%idx-order-item_id}}',
            '{{%order}}',
            'item_id'
        );

        // add foreign key for table `{{%item}}`
        $this->addForeignKey(
            '{{%fk-order-item_id}}',
            '{{%order}}',
            'item_id',
            '{{%item}}',
            'id',
            'CASCADE'
        );

        // creates index for column `city_id`
        $this->createIndex(
            '{{%idx-order-city_id}}',
            '{{%order}}',
            'city_id'
        );

        // add foreign key for table `{{%city}}`
        $this->addForeignKey(
            '{{%fk-order-city_id}}',
            '{{%order}}',
            'city_id',
            '{{%city}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        // drops foreign key for table `{{%client}}`
        $this->dropForeignKey(
            '{{%fk-order-client_id}}',
            '{{%order}}'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            '{{%idx-order-client_id}}',
            '{{%order}}'
        );

        // drops foreign key for table `{{%item}}`
        $this->dropForeignKey(
            '{{%fk-order-item_id}}',
            '{{%order}}'
        );

        // drops index for column `item_id`
        $this->dropIndex(
            '{{%idx-order-item_id}}',
            '{{%order}}'
        );

        // drops foreign key for table `{{%city}}`
        $this->dropForeignKey(
            '{{%fk-order-city_id}}',
            '{{%order}}'
        );

        // drops index for column `city_id`
        $this->dropIndex(
            '{{%idx-order-city_id}}',
            '{{%order}}'
        );

        // drops foreign key for table `{{%partner}}`
        $this->dropForeignKey(
            '{{%fk-order-report_id}}',
            '{{%order}}'
        );

        // drops index for column `report_id`
        $this->dropIndex(
            '{{%idx-order-report_id}}',
            '{{%order}}'
        );

        $this->dropTable('{{%order}}');
    }
}
