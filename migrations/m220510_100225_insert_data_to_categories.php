<?php

use yii\db\Migration;

/**
 * Class m220510_100225_insert_data_to_categories
 */
class m220510_100225_insert_data_to_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $categories = include "categories.php";
        foreach ($categories as $cat) {
            $this->insert('{{%categories}}', $cat);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220510_100225_insert_data_to_categories cannot be reverted.\n";
        $this->truncateTable('{{%categories}}');
        return false;
    }

}
