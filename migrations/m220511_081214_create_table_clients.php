<?php

use yii\db\Migration;

/**
 * Class m220511_081214_create_table_clients
 */
class m220511_081214_create_table_clients extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%clients}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'user_id' => $this->integer()->unsigned()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('idx-clients-user_id-index-unique', '{{%clients}}', ['user_id'], true);
        $this->addForeignKey(
            'fx-clients-user_id',
            '{{%clients}}',
            ['user_id'],
            '{{%users}}',
            ['id'],
            'CASCADE',
            'NO ACTION'
        );
    }

    public function down()
    {
        $this->dropTable('{{%clients}}');
    }
}
