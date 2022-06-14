<?php

use yii\db\Migration;

/**
 * Class m220611_115554_create_table_bids
 */
class m220611_115554_create_table_bids extends Migration
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
            '{{%bids}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'employee_id' => $this->integer()->unsigned()->notNull(),
                'description' => $this->string()->notNull(),
                'price' => $this->integer()->unsigned(),
                'task_id' => $this->integer()->unsigned()->notNull(),
                'created' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('idx-bids-employee_id-task_id-unique', '{{%bids}}', ['employee_id', 'task_id'], true);

        $this->addForeignKey(
            'fx-bids-employee_id',
            '{{%bids}}',
            ['employee_id'],
            '{{%employees}}',
            ['user_id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'fx-bids-task_id',
            '{{%bids}}',
            ['task_id'],
            '{{%tasks}}',
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
        echo "m220611_115554_create_table_bids cannot be reverted.\n";
        $this->dropForeignKey('idx-bids-employee_id-task_id-unique', '{{%bids}}');
        $this->dropForeignKey('fx-bids-task_id', '{{%bids}}');
        $this->dropTable('{{%bids}}');
    }

}
