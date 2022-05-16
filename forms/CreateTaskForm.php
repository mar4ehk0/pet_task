<?php

namespace app\forms;

use app\models\Category;
use app\models\City;
use app\models\Client;
use app\repositories\CategoryRepository;
use app\repositories\CityRepository;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CreateTaskForm extends Model
{
    public string $title = '';
    public string $description = '';
    public int $category_id = 1;
    public string $location = '';
    public string $address = '';
    public int $city_id = 1;
    public string $lat = '';
    public string $long = '';
    public int $price = 1;
    public string $deadline = '';
    public bool $is_remote = false;
    public int $client_id;

    private CityRepository $cityRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(
        int $client_id,
        CityRepository $cityRepository,
        CategoryRepository $categoryRepository,
        $config = []
    )
    {
        parent::__construct($config);
        $this->cityRepository = $cityRepository;
        $this->categoryRepository = $categoryRepository;
        $this->client_id = $client_id;
    }

    public function rules()
    {
        return [
            [['title', 'description', 'category_id', 'client_id', 'price'], 'required'],
            [['category_id', 'client_id'], 'integer'],
            [['title', 'description', 'location', 'address'], 'string'],
            [['lat', 'long'], 'string', 'max' => 100],
            ['price', 'integer', 'min' => 1],
            ['is_remote', 'safe'],
            [['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::class,
                'targetAttribute' => ['category_id' => 'id']],
            [['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::class,
                'targetAttribute' => ['city_id' => 'id']],
            ['deadline', 'guardIsActualDate', 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание задачи',
            'category_id' => 'Категория',
            'price' => 'Бюджет',
            'deadline' => 'Срок завершения',
            'is_remote' => 'Удаленная работа',
            'location' => 'Адрес',
        ];
    }

    public function guardIsActualDate($attribute, $params, $validator)
    {
        if (!isset($this->{$attribute})) {
            return false;
        }

        $currentDate = new \DateTime();
        $deadline = new \DateTime($this->{$attribute});
        if ($currentDate > $deadline) {
            $this->addError($attribute, 'Срок завершения не может быть меньше текущей даты.');
            return false;
        }

        return true;
    }

    public function getCityList(): array
    {
        return ArrayHelper::map($this->cityRepository->findAll(), 'id', 'name');
    }

    public function getCategoryList(): array
    {
        return ArrayHelper::map($this->categoryRepository->findAll(), 'id', 'human_name');
    }
}