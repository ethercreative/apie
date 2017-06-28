<?php

namespace ethercreative\apie\database\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `team`.
 */
class m170614_145141_create_team_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('team', [
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
        $this->dropTable('team');
    }
}
