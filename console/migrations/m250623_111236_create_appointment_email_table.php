<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%appointment_email}}`.
 */
class m250623_111236_create_appointment_email_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%appointment_email}}', [
            'id' => $this->primaryKey(),
            'appointment_id' => $this->integer()->notNull(),
            'subject' => $this->string(),
            'email_content' => $this->text(),
            'generated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-appointment_email-appointment',
            '{{%appointment_email}}',
            'appointment_id',
            '{{%appointment}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-appointment_email-appointment', '{{%appointment_email}}');
        $this->dropTable('{{%appointment_email}}');
    }
}
