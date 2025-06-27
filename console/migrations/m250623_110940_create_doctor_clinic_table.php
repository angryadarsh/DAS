<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%doctor_clinic}}`.
 */
class m250623_110940_create_doctor_clinic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%doctor_clinic}}', [
            'id' => $this->primaryKey(),
            'doctor_id' => $this->integer()->notNull(),
            'clinic_id' => $this->integer()->notNull(),
        ]);

        // Foreign Keys
        $this->addForeignKey(
            'fk-doctor_clinic-doctor',
            '{{%doctor_clinic}}',
            'doctor_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-doctor_clinic-clinic',
            '{{%doctor_clinic}}',
            'clinic_id',
            '{{%clinic}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-doctor_clinic-doctor', '{{%doctor_clinic}}');
        $this->dropForeignKey('fk-doctor_clinic-clinic', '{{%doctor_clinic}}');
        $this->dropTable('{{%doctor_clinic}}');
    }
}
