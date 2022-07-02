<?php

namespace app\controllers;

use app\rbac\RBACManager;
use yii\filters\AccessControl;

class FeedbackController extends \yii\web\Controller
{

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

    public function actionCreate($id)
    {

    }
}