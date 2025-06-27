<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%doctor_schedule}}`.
 */
class m250623_111048_create_doctor_schedule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%doctor_schedule}}', [
            'id' => $this->primaryKey(),
            'doctor_id' => $this->integer()->notNull(),
            'day_of_week' => "ENUM('Mon','Tue','Wed','Thu','Fri','Sat','Sun') NOT NULL",
            'start_time' => $this->time(),
            'end_time' => $this->time(),
            'is_holiday' => $this->boolean()->defaultValue(false),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-doctor_schedule-doctor',
            '{{%doctor_schedule}}',
            'doctor_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-doctor_schedule-doctor', '{{%doctor_schedule}}');
        $this->dropTable('{{%doctor_schedule}}');
    }
}
