<?php

namespace app\forms;

use app\models\Category;
use app\models\City;
use app\repositories\CategoryRepository;
use app\repositories\CityRepository;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class CreateTaskForm extends AbstractForm
{
    public string $title = '';
    public string $description = '';
    public ?int $category_id = null;
    public string $location = '';
    public string $address = '';
    public string $city_id = '';
    public string $lat = '';
    public string $long = '';
    public string $price = '';
    public string $deadline = '';
    public bool $is_remote = false;
    public ?array $files = null;
    public int $client_id;

    private CityRepository $cityRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(
        int $client_id,
        CityRepository $cityRepository,
        CategoryRepository $categoryRepository,
        $config = []
    ) {
        parent::__construct($config);
        $this->cityRepository = $cityRepository;
        $this->categoryRepository = $categoryRepository;
        $this->client_id = $client_id;
    }

    public function rules()
    {
        return [
            [['title', 'description', 'category_id', 'client_id'], 'required'],
            [['category_id', 'client_id'], 'integer'],
            [['title', 'description', 'location', 'address'], 'string'],
            [['lat', 'long'], 'string', 'max' => 100],
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
            ['price', 'guardIsValidPrice', 'skipOnEmpty' => false, 'skipOnError' => false],
            [['files'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg, pdf, txt, doc, docx',
                'maxFiles' => 4],
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
            'files' => 'Файлы',
        ];
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
