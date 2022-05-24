<?php

namespace app\forms;

use app\helpers\ViewHelper;
use app\repositories\CategoryRepository;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class FindTaskForm extends Model
{

    public array $categories = [];
    public array $status = [];
    public string $period = '';

    private CategoryRepository $categoryRepository;
    private array $get;

    public function __construct(CategoryRepository $categoryRepository, array $get, $config = [])
    {
        parent::__construct($config);
        $this->categoryRepository = $categoryRepository;
        $this->get = $get;
    }

    public function rules()
    {
        return [
            [['categories', 'status'], 'safe'],
            [['period'], 'string'],
//            ['price', 'guardIsValidPrice', 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'status' => 'Статус',
            'period' => 'Период',
        ];
    }

    public function getCategoryList(): array
    {
        return ArrayHelper::map($this->categoryRepository->findAll(), 'id', 'human_name');
    }

    public function getPeriodList(): array
    {
        return [
            '5 second' => 'Только что',
            '1 hour' => '1 час',
            '2 hour' => '2 часа',
            '4 hour' => '4 часа',
            '8 hour' => '8 часов',
            '12 hour' => '12 часов',
            '24 hour' => '24 часа',
            '2 day' => '2 дня',
            '3 day' => '3 дня',
        ];
    }

    public function getListStatus(): array
    {
        return ViewHelper::getListStatusTask();
    }
}