<?php

namespace ethercreative\apie\database\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `refresh_token`.
 */
class m170609_131027_create_refresh_token_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('refresh_token', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'token' => $this->string()->notNull(),
            'device' => $this->string(),
            'ip' => $this->string(),
            'expire_at' => $this->timestamp()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);

        $this->addForeignKey('refresh_token_user_id_fk', 'refresh_token', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('refresh_token_token_i', 'refresh_token', 'token', true);
        $this->createIndex('refresh_token_expire_at_i', 'refresh_token', 'expire_at');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('refresh_token');
    }
}
