<?php

use yii\db\Migration;

/**
 * Class m220511_073753_create_table_users
 */
class m220511_073753_create_table_users extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%users}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'email' => $this->string()->notNull(),
                'name' => $this->string()->notNull(),
                'password' => $this->string(64)->notNull(),
                'birthday' => $this->dateTime()->notNull(),
                'city_id' => $this->integer()->unsigned()->notNull(),
                'avatar' => $this->string(),
                'created' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('idx-users-email-index-unique', '{{%users}}', ['email'], true);
        $this->addForeignKey(
            'fx-users-city_id',
            '{{%users}}',
            ['city_id'],
            '{{%cities}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
    }

    public function down()
    {
        $this->dropTable('{{%users}}');
    }
}
