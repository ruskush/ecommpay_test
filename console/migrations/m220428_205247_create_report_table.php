<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%report}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%partner}}`
 */
class m220428_205247_create_report_table extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%report}}', [
            'id' => $this->primaryKey(),
            'report_at' => $this->date()->notNull(),
            'partner_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `partner_id`
        $this->createIndex(
            '{{%idx-report-partner_id}}',
            '{{%report}}',
            'partner_id'
        );

        // add foreign key for table `{{%partner}}`
        $this->addForeignKey(
            '{{%fk-report-partner_id}}',
            '{{%report}}',
            'partner_id',
            '{{%partner}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        // drops foreign key for table `{{%partner}}`
        $this->dropForeignKey(
            '{{%fk-report-partner_id}}',
            '{{%report}}'
        );

        // drops index for column `partner_id`
        $this->dropIndex(
            '{{%idx-report-partner_id}}',
            '{{%report}}'
        );

        $this->dropTable('{{%report}}');
    }
}
