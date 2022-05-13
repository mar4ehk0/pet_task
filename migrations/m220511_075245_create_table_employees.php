<?php

use yii\db\Migration;

/**
 * Class m220511_075245_create_table_employees
 */
class m220511_075245_create_table_employees extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%employees}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'user_id' => $this->integer()->unsigned()->notNull(),
                'about' => $this->text()->notNull(),
                'phone' => $this->string(11)->notNull(),
                'telegram' => $this->string(64),
                'hide_contacts' => $this->boolean()->notNull(),
                'rating' => $this->float(),
            ],
            $tableOptions
        );

        $this->createIndex('idx-employees-user_id-index-unique', '{{%employees}}', ['user_id'], true);
        $this->addForeignKey(
            'fx-employees-user_id',
            '{{%employees}}',
            ['user_id'],
            '{{%users}}',
            ['id'],
            'CASCADE',
            'NO ACTION'
        );
    }

    public function down()
    {
        $this->dropTable('{{%employees}}');
    }
}
