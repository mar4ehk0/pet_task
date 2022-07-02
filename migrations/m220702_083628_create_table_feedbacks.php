<?php

use yii\db\Migration;

/**
 * Class m220702_083628_create_table_feedbacks
 */
class m220702_083628_create_table_feedbacks extends Migration
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
            '{{%feedbacks}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'body' => $this->text()->notNull(),
                'grade' => $this->integer()->notNull(),
                'task_id' => $this->integer()->unsigned()->notNull(),
                'created' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('idx-feedbacks-task_id-unique', '{{%feedbacks}}', ['task_id'], true);

        $this->addForeignKey(
            'fx-feedbacks-task_id',
            '{{%feedbacks}}',
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
        $this->dropForeignKey('fx-feedbacks-task_id', '{{%feedbacks}}');
        $this->dropIndex('idx-feedbacks-task_id-unique', '{{%feedbacks}}');
        $this->dropTable('{{%feedbacks}}');
    }
}
