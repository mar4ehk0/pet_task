<?php

use yii\db\Migration;

/**
 * Class m220704_135638_add_num_failed_task_column_to_employees
 */
class m220704_135638_add_num_failed_task_column_to_employees extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%employees}}', 'num_failed_task', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%employees}}', 'num_failed_task');
    }
}
