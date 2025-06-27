<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%appointment_log}}`.
 */
class m250623_111326_create_appointment_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%appointment_log}}', [
            'id' => $this->primaryKey(),
            'appointment_id' => $this->integer()->notNull(),
            'action' => $this->string(50),
            'performed_by' => $this->integer(),
            'performed_at' => $this->integer(),
            'details' => $this->text(),
        ]);

        $this->addForeignKey(
            'fk-appointment_log-appointment',
            '{{%appointment_log}}',
            'appointment_id',
            '{{%appointment}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-appointment_log-user',
            '{{%appointment_log}}',
            'performed_by',
            '{{%user}}',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-appointment_log-user', '{{%appointment_log}}');
        $this->dropForeignKey('fk-appointment_log-appointment', '{{%appointment_log}}');
        $this->dropTable('{{%appointment_log}}');
    }
}
