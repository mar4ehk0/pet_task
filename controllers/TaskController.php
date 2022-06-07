<?php

namespace app\controllers;

use app\forms\CreateTaskForm;
use app\forms\FindTaskForm;
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
            $task = $this->taskService->create($model);
            Yii::$app->session->setFlash('success', 'Задача создана.');
            $this->redirect(['task/view', 'id' => $task->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->taskService->getTaskView($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionClients()
    {
        $client_id = \Yii::$app->user->identity->getId();
        $searchTaskView = $this->taskService->getSearchTaskView($client_id, Yii::$app->request->get());
        return $this->render('client', ['model' => $searchTaskView]);
    }

    public function actionBid($id)
    {

    }

    public function actionCancel($id)
    {

    }

    public function actionAbort($id)
    {

    }

    public function actionComplete($id)
    {

    }
}