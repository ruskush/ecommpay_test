<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client}}`.
 */
class m220428_204121_create_client_table extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
        $this->createIndex('idx-client_name', '{{%client}}', 'name', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%client}}');
    }
}
