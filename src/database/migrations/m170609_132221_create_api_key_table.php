<?php

use yii\db\Migration;

/**
 * Handles the creation of table `api_key`.
 */
class m170609_132221_create_api_key_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('api_key', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'token' => $this->string()->notNull(),
            'meta' => 'jsonb',
            'expire_at' => $this->timestamp()->notNull(),
            'used_at' => $this->timestamp(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);

        $this->addForeignKey('api_key_user_id_fk', 'api_key', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('api_key_token_i', 'api_key', 'token', true);
        $this->createIndex('api_key_expires_i', 'api_key', 'expire_at');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('api_key');
    }
}
