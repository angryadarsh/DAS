<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%doctor}}`.
 */
class m250623_160012_create_doctor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%doctor}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'specialization' => $this->string()->notNull(),
            'qualification' => $this->string()->notNull(),
            'experience' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Add foreign key to user table
        $this->addForeignKey(
            'fk-doctor-user_id',
            '{{%doctor}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-doctor-user_id', '{{%doctor}}');
        $this->dropTable('{{%doctor}}');
    }
}
