<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%files}}`.
 */
class m220521_112334_add_size_column_to_files_table extends Migration
{
    public function up()
    {
        $this->addColumn('files', 'size', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn('files', 'size');
    }
}
