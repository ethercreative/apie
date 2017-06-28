<?php

use yii\db\Migration;

/**
 * Handles the creation of table `team_user`.
 */
class m170614_145201_create_team_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('team_user', [
            'id' => $this->primaryKey(),
            'team_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'role' => $this->string()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);

        $this->addForeignKey('team_user_team_id_fk', 'team_user', 'team_id', 'team', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('team_user_user_id_fk', 'team_user', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('team_user_team_id_user_id_uq', 'team_user', ['team_id', 'user_id'], true);
        $this->createIndex('team_user_role_i', 'team_user', 'role');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('team_user');
    }
}
