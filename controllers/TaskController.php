<?php

namespace app\controllers;

use app\forms\CreateTaskForm;
use app\repositories\CategoryRepository;
use app\repositories\CityRepository;
use app\services\TaskService;
use Yii;

class TaskController extends \yii\web\Controller
{

    private CityRepository $cityRepository;
    private CategoryRepository $categoryRepository;
    private TaskService $taskService;

    public function __construct(
        $id,
        $module,
        CityRepository $cityRepository,
        CategoryRepository $categoryRepository,
        TaskService $taskService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->cityRepository = $cityRepository;
        $this->categoryRepository = $categoryRepository;
        $this->taskService = $taskService;
    }

    public function actionCreate()
    {
        $client_id = \Yii::$app->user->identity->getId();

        $model = new CreateTaskForm($client_id, $this->cityRepository, $this->categoryRepository);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $this->taskService->create($model);
            Yii::$app->session->setFlash('success', 'Задача создана.');
//            $this->redirect('task/view');
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
//
//    public function actionView()
//    {
//        return $this->render('view', [
//            'model' => $model,
//        ]);
//    }
}