<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%role_column_user}}`.
 */
class m250623_105926_create_role_column_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('{{%user}}', 'role', "ENUM('patient', 'doctor', 'superadmin') NULL DEFAULT 'patient' AFTER `verification_token`");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // $this->dropTable('{{%role_column_user}}');
    }
}
