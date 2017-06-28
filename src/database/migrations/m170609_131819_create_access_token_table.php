<?php

namespace ethercreative\apie\database\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `access_token`.
 */
class m170609_131819_create_access_token_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('access_token', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'refresh_id' => $this->integer()->notNull(),
            'token' => $this->string()->notNull(),
            'expire_at' => $this->timestamp()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);

        $this->addForeignKey('access_token_user_id_fk', 'access_token', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('access_token_refresh_id_fk', 'access_token', 'refresh_id', 'refresh_token', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('access_token_token_i', 'access_token', 'token', true);
        $this->createIndex('access_token_expire_at_i', 'access_token', 'expire_at');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('access_token');
    }
}
