<?php

use yii\db\Migration;

/**
 * Class m220519_172122_create_table_files
 */
class m220519_172122_create_table_files extends Migration
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
            '{{%files}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'name' => $this->string()->notNull(),
                'extension' => $this->string()->notNull(),
                'path' => $this->string()->notNull(),
                'client_id' => $this->integer()->unsigned()->notNull(),
                'task_id' => $this->integer()->unsigned()->notNull(),
                'created' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->addForeignKey(
            'fx-files-client_id',
            '{{%files}}',
            ['client_id'],
            '{{%clients}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );

        $this->addForeignKey(
            'fx-files-task_id',
            '{{%files}}',
            ['task_id'],
            '{{%tasks}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );

        $this->createIndex(
            'idx-files-index-unique',
            '{{%files}}',
            ['name', 'extension', 'task_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220519_172122_create_table_files cannot be reverted.\n";
        $this->dropForeignKey('fx-files-client_id', '{{%files}}');
        $this->dropForeignKey('fx-files-task_id', '{{%files}}');
        $this->dropIndex('idx-files-index-unique', '{{%files}}');
        $this->dropTable('{{%files}}');
    }

}
