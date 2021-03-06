<?php

namespace app\models;

use app\services\dto\ContactDTO;
use app\services\dto\EmployeeDTO;
use Yii;

/**
 * This is the model class for table "employees".
 *
 * @property int $id
 * @property int $user_id
 * @property string $about
 * @property string $phone
 * @property string|null $telegram
 * @property int $hide_contacts
 * @property float|null $rating
 * @property int $num_failed_task
 *
 * @property User $user
 * @property Category[] $categories
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])
            ->viaTable('categories_employees', ['employee_id' => 'id']);
    }

    /**
     * @param User $user
     * @param string $about
     * @param ContactDTO $contactDTO
     * @param Category[] $categories
     * @return Employee
     */
    public static function create(User $user, string $about, ContactDTO $contactDTO, array $categories): Employee
    {
        $employee = new self();
        $employee->populateRelation('user', $user);
        $employee->about = $about;
        $employee->phone = $contactDTO->phone;
        $employee->telegram = $contactDTO->telegram;
        $employee->hide_contacts = false;
        $employee->rating = 0;
        $employee->populateRelation('categories', $categories);
        return $employee;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $related = $this->getRelatedRecords();
            /** @var User $user */
            if (isset($related['user']) && $user = $related['user']) {
                $user->save();
                $this->user_id = $user->id;
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $related = $this->getRelatedRecords();
        if (isset($related['categories']) && $categories = $related['categories']) {
            /** @var Category $category */
            foreach ($categories as $category) {
                $this->link('categories', $category);
            }
        }
    }

    public function incNumFailedTask(): void
    {
        $this->num_failed_task++;
    }
}
