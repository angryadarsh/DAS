<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%appointment}}`.
 */
class m250623_111130_create_appointment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%appointment}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'doctor_id' => $this->integer()->notNull(),
            'clinic_id' => $this->integer()->notNull(),
            'appointment_date' => $this->date()->notNull(),
            'start_time' => $this->time()->notNull(),
            'end_time' => $this->time()->notNull(),
            'duration_minutes' => $this->integer()->defaultValue(10),
            'price' => $this->integer()->notNull(),
            'status' => "ENUM('booked', 'cancelled', 'completed') DEFAULT 'booked'",
            'created_by' => "ENUM('user','doctor') NOT NULL",
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        // Foreign Keys
        $this->addForeignKey('fk-appointment-user', '{{%appointment}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-appointment-doctor', '{{%appointment}}', 'doctor_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-appointment-clinic', '{{%appointment}}', 'clinic_id', '{{%clinic}}', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-appointment-user', '{{%appointment}}');
        $this->dropForeignKey('fk-appointment-doctor', '{{%appointment}}');
        $this->dropForeignKey('fk-appointment-clinic', '{{%appointment}}');
        $this->dropTable('{{%appointment}}');
    }
}
