<?php

namespace app\controllers;

use app\forms\FeedbackForm;
use app\rbac\RBACManager;
use app\services\FeedbackService;
use yii\filters\AccessControl;

class FeedbackController extends \yii\web\Controller
{

    private FeedbackService $feedbackService;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => [RBACManager::CLIENT],
                    ],
                ],
            ],
        ];
    }

    public function __construct(
        $id,
        $module,
        FeedbackService $feedbackService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->feedbackService = $feedbackService;
    }

    public function actionCreate($task_id)
    {
        $model = new FeedbackForm($task_id);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $this->feedbackService->createFeedback($model);
            \Yii::$app->session->setFlash('success', 'Отзыв сохранен.');
            $this->redirect(['task/view', 'id' => $model->task->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
}