<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $system_name
 * @property string $human_name
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    public function getEmployees(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Employee::class, ['id' => 'employee_id'])
            ->viaTable('categories_employees', ['category_id' => 'id']);
    }
}
