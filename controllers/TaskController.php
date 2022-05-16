<?php

namespace app\controllers;

use app\forms\CreateTaskForm;
use app\repositories\CategoryRepository;
use app\repositories\CityRepository;

class TaskController extends \yii\web\Controller
{

    private CityRepository $cityRepository;
    private CategoryRepository $categoryRepository;

    public function __construct($id, $module, CityRepository $cityRepository, CategoryRepository $categoryRepository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->cityRepository = $cityRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function actionCreate()
    {
        $client_id = \Yii::$app->user->identity->getId();

        $model = new CreateTaskForm($client_id, $this->cityRepository, $this->categoryRepository);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {

        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
}