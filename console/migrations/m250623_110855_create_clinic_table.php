<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clinic}}`.
 */
class m250623_110855_create_clinic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clinic}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'address' => $this->text(),
            'city' => $this->string(100),
            'state' => $this->string(100),
            'pincode' => $this->string(10),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clinic}}');
    }
}
