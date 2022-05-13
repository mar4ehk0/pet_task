<?php

use yii\db\Migration;

/**
 * Class m220510_095810_create_table_categories
 */
class m220510_095810_create_table_categories extends Migration
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
            '{{%categories}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'system_name' => $this->string(255)->notNull(),
                'human_name' => $this->string(255)->notNull(),
            ],
            $tableOptions
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220510_095810_create_table_categories cannot be reverted.\n";
        $this->dropTable('{{%categories}}');
        return false;
    }

}
