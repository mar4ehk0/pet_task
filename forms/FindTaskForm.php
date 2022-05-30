<?php

namespace app\forms;

use app\dtos\PeriodDTO;
use app\helpers\ViewHelper;
use app\repositories\CategoryRepository;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class FindTaskForm extends Model
{

    public const STATUS_ANY = ['any' => 'Любой'];
    public const PERIOD_ANY = ['any' => 'Любой'];

    public array $categories = [];
    public string $status = '';
    public string $period = '';
    private int $client_id = 0;


    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository, int $client_id, array $get, $config = [])
    {
        parent::__construct($config);
        $this->categoryRepository = $categoryRepository;
        $this->period = key(self::PERIOD_ANY);
        if (!empty($get['FindTaskForm'])) {
            $this->setDefault($get['FindTaskForm']);
        }

        $this->client_id = $client_id;
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
        return array_merge(
            self::PERIOD_ANY,
            [
                '1 minute' => 'Только что',
                '1 hour' => '1 час',
                '2 hour' => '2 часа',
                '4 hour' => '4 часа',
                '8 hour' => '8 часов',
                '12 hour' => '12 часов',
                '24 hour' => '24 часа',
                '2 day' => '2 дня',
                '3 day' => '3 дня',
            ]
        );
    }

    public function getListStatus(): array
    {
        return array_merge(self::STATUS_ANY, ViewHelper::getListStatusTask());
    }

    public function getCategoriesId(): ?array
    {
        if (empty($this->categories)) {
            return null;
        }

        return array_keys($this->categories);
    }

    public function getStatus(): ?string
    {
        if ($this->status === key(self::STATUS_ANY)) {
            return null;
        }
        return $this->status;
    }

    public function getPeriod(): ?PeriodDTO
    {
        if ($this->period === key(self::STATUS_ANY)) {
            return null;
        }
        $from = new \DateTime();
        $to = new \DateTime($this->period);
        return  new PeriodDTO($from->format('Y-m-d'),$to->format('Y-m-d'));
    }

    private function setDefault(array $get): void
    {
        if (!empty($get['categories'])) {
            $this->categories = $get['categories'];
        }
        if (!is_null($get['status'])) {
            $this->status = $get['status'];
        }
        if (!empty($get['period'])) {
            $this->period = $get['period'];
        }
    }

    public function getClientId(): ?int
    {
        if ($this->client_id === 0) {
            return null;
        }

        return $this->client_id;
    }
}