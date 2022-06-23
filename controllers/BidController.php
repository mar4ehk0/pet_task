<?php

namespace app\controllers;

use app\rbac\RBACManager;
use yii\filters\AccessControl;

class BidController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['accept'],
                        'roles' => [RBACManager::CLIENT],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['decline'],
                        'roles' => [RBACManager::CLIENT],
                    ],
                ],
            ],
        ];
    }


    public function actionAccept($id)
    {
        echo __FUNCTION__;
    }

    public function actionDecline($id)
    {
        echo __FUNCTION__;
    }
}