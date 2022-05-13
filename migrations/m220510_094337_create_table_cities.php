<?php

use yii\db\Migration;

/**
 * Class m220510_094337_create_table_cities
 */
class m220510_094337_create_table_cities extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%cities}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'name' => $this->string()->notNull(),
                'lat' => $this->string(100)->notNull(),
                'long' => $this->string(100)->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('idx-cities-index-unique', '{{%cities}}', ['name', 'lat', 'long'], true);
    }

    public function down()
    {
        $this->dropTable('{{%cities}}');
    }
}
