<?php

use yii\db\Migration;

/**
 * Class m220705_143552_create_table_categories_employees
 */
class m220705_143552_create_table_categories_employees extends Migration
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
            '{{%categories_employees}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'category_id' => $this->integer()->unsigned()->notNull(),
                'employee_id' => $this->integer()->unsigned()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex(
            'idx-categories_employees-category_id_employee_id-unique',
            '{{%categories_employees}}',
            ['category_id', 'employee_id'],
            true
        );

        $this->addForeignKey(
            'fx-categories_employees-category_id',
            '{{%categories_employees}}',
            ['category_id'],
            '{{%categories}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'fx-categories_employees-employee_id',
            '{{%categories_employees}}',
            ['employee_id'],
            '{{%employees}}',
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
        $this->dropForeignKey('fx-categories_employees-employee_id', '{{%categories_employees}}');
        $this->dropForeignKey('fx-categories_employees-category_id', '{{%categories_employees}}');
        $this->dropIndex('idx-categories_employees-category_id_employee_id-unique', '{{%categories_employees}}');
        $this->dropTable('{{%categories_employees}}');
    }

}
