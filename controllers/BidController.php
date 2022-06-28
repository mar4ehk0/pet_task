<?php

namespace app\controllers;

use app\forms\CreateBidForm;
use app\rbac\RBACManager;
use app\services\BidService;
use Yii;
use yii\filters\AccessControl;

class BidController extends \yii\web\Controller
{
    private BidService $bidService;

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
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => [RBACManager::EMPLOYEE],
                    ],
                ],
            ],
        ];
    }


    public function __construct(
        $id,
        $module,
        BidService $bidService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->bidService = $bidService;
    }

    public function actionCreate($id)
    {
        $employee_id = Yii::$app->user->identity->getId();

        $model = new CreateBidForm($employee_id, $id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $bid = $this->bidService->createBid($model);
            Yii::$app->session->setFlash('success', 'Ваша предложение отправлено.');
            $this->redirect(['task/view', 'id' => $id]);
        }
        return $this->render('bid', ['model' => $model]);
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