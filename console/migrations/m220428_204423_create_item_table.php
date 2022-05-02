<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%item}}`.
 */
class m220428_204423_create_item_table extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%item}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
        $this->createIndex('idx-item_name', '{{%item}}', 'name', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%item}}');
    }
}
