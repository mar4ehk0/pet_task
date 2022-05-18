<?php

use yii\db\Migration;

/**
 * Class m220513_084221_create_table_tasks
 */
class m220513_084221_create_table_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%tasks}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'title' => $this->string()->notNull(),
                'description' => $this->string()->notNull(),
                'category_id' => $this->integer()->unsigned()->notNull(),
                'client_id' => $this->integer()->unsigned()->notNull(),
                'employee_id' => $this->integer()->unsigned(),
                'city_id' => $this->integer()->unsigned(),
                'location' => $this->string(),
                'address' => $this->string(),
                'lat' => $this->string(100),
                'long' => $this->string(100),
                'is_remote' => $this->boolean()->notNull(),
                'price' => $this->integer()->unsigned(),
                'deadline' => $this->dateTime()->notNull(),
                'status' => $this->integer()->notNull(),
                'created' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->addForeignKey(
            'fx-tasks-category_id',
            '{{%tasks}}',
            ['category_id'],
            '{{%categories}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );

        $this->addForeignKey(
            'fx-tasks-client_id',
            '{{%tasks}}',
            ['client_id'],
            '{{%clients}}',
            ['user_id'],
            'CASCADE',
            'NO ACTION'
        );

        $this->addForeignKey(
            'fx-tasks-employee_id',
            '{{%tasks}}',
            ['employee_id'],
            '{{%employees}}',
            ['user_id'],
            'CASCADE',
            'NO ACTION'
        );

        $this->addForeignKey(
            'fx-tasks-city_id',
            '{{tasks}}',
            ['city_id'],
            '{{cities}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220513_084221_create_table_tasks cannot be reverted.\n";
        $this->dropForeignKey('fx-tasks-category_id', '{{%tasks}}');
        $this->dropForeignKey('fx-tasks-client_id', '{{%tasks}}');
        $this->dropForeignKey('fx-tasks-employee_id', '{{%tasks}}');
        $this->dropForeignKey('fx-tasks-city_id', '{{%tasks}}');
        $this->dropTable('{{%tasks}}');
    }

}
