<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_reset`.
 */
class m171026_144107_add_slug_column_to_team_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('team', 'slug', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('team', 'slug');
    }
}
