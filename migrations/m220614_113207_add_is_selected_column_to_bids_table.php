<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%bids}}`.
 */
class m220614_113207_add_is_selected_column_to_bids_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%bids}}', 'is_selected', $this->boolean()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%bids}}', 'is_selected');
    }
}
