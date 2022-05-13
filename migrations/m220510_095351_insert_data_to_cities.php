<?php

use yii\db\Migration;

/**
 * Class m220510_095351_insert_data_to_cities
 */
class m220510_095351_insert_data_to_cities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $cities = include "cities.php";
        foreach ($cities as $city) {
            $this->insert('{{%cities}}', $city);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220510_095351_insert_data_to_cities cannot be reverted.\n";
        $this->truncateTable('{{%cities}}');
        return false;
    }

}
