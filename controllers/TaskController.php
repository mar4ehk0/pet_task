<?php

namespace app\controllers;

use app\forms\CreateTaskForm;
use app\rbac\RBACManager;
use app\repositories\CategoryRepository;
use app\repositories\CityRepository;
use app\services\TaskService;
use Yii;
use yii\filters\AccessControl;

class TaskController extends \yii\web\Controller
{
    private CityRepository $cityRepository;
    private CategoryRepository $categoryRepository;
    private TaskService $taskService;


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'clients', 'view', 'employees', 'cancel', 'abort'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => [RBACManager::CLIENT],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['clients'],
                        'roles' => [RBACManager::CLIENT],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['employees'],
                        'roles' => [RBACManager::EMPLOYEE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['cancel'],
                        'roles' => [RBACManager::CLIENT],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['abort'],
                        'roles' => [RBACManager::EMPLOYEE],
                    ],
                ],
            ],
        ];
    }

    public function __construct(
        $id,
        $module,
        CityRepository $cityRepository,
        CategoryRepository $categoryRepository,
        TaskService $taskService,
        $config = []
    ) {
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
            Yii::$app->session->setFlash('success', '???????????? ??????????????.');
            $this->redirect(['task/view', 'id' => $task->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $user_id = \Yii::$app->user->identity->getId();
        $model = $this->taskService->getTaskPageView($id, $user_id);

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

    public function actionEmployees()
    {
        $searchTaskView = $this->taskService->getSearchTaskView(0, Yii::$app->request->get());
        return $this->render('employee', ['model' => $searchTaskView]);
    }

    public function actionCancel($id)
    {
        $this->taskService->cancelTask($id);
        $this->redirect(['task/view', 'id' => $id]);
    }

    public function actionAbort($id)
    {
        $this->taskService->abortTask($id);
        $this->redirect(['task/view', 'id' => $id]);
    }
}
