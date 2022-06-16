<?php

use yii\db\Migration;

/**
 * Class m220616_170504_rename_is_selected_column_to_is_declined_for_bids_table
 */
class m220616_170504_rename_is_selected_column_to_is_declined_for_bids_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%bids}}', 'is_selected', 'is_declined');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220616_170504_rename_is_selected_column_to_is_declined_for_bids_table cannot be reverted.\n";

        return false;
    }

}
