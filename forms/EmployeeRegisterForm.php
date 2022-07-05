<?php

namespace app\forms;

use app\repositories\CategoryRepository;
use app\repositories\CityRepository;
use yii\helpers\ArrayHelper;

class EmployeeRegisterForm extends UserRegisterForm
{
    public string $about = '';
    public string $phone = '';
    public string $telegram = '';
    public array $categories_id = [];
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository, CityRepository $cityRepository, $config = [])
    {
        parent::__construct($cityRepository, $config);
        $this->categoryRepository = $categoryRepository;
    }


    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['about', 'phone'], 'required'];
        $rules[] = [['telegram'], 'string', 'max' => 64];
        $rules[] = ['categories_id',
            'guardIsExistEachElementCategoriesId',
            'skipOnEmpty' => false,
            'skipOnError' => false];
        return $rules;
    }

    public function guardIsExistEachElementCategoriesId($attribute, $params, $validator)
    {
        if (!isset($this->{$attribute}) || !is_array($this->{$attribute})) {
            return false;
        }

        $categories = $this->categoryRepository->findMultiple($this->{$attribute});
        return !(count($categories) !== count($this->{$attribute}));
    }

    public function attributeLabels()
    {
        $attr = parent::attributeLabels();
        return array_merge(
            $attr,
            [
                'about' => 'О вас',
                'phone' => 'Номер телефона',
                'telegram' => 'мессенджер-телеграм',
                'categories_id' => 'Категории',
            ]
        );
    }

    public function getCategoryList(): array
    {
        return ArrayHelper::map($this->categoryRepository->findAll(), 'id', 'human_name');
    }
}
