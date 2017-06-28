<?php

namespace ethercreative\apie\database\migrations;

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

            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('team_user');
    }
}
