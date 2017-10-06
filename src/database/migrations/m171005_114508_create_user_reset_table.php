<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_reset`.
 */
class m171005_114508_create_user_reset_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('user_reset', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'code' => $this->string(48),
            'expires_at' => $this->dateTime(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->addForeignKey('user_reset_user_id_fkey', 'user_reset', 'user_id', 'user', 'id', 'CASCADE');
        $this->createIndex('user_reset_code_i', 'user_reset', 'code', true);
        $this->createIndex('user_reset_expires_at_i', 'user_reset', 'expires_at');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('user_reset');
    }
}
