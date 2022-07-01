<?php

namespace app\controllers;

use app\forms\CreateBidForm;
use app\rbac\RBACManager;
use app\repositories\BidRepository;
use app\services\BidService;
use Yii;
use yii\filters\AccessControl;

class BidController extends \yii\web\Controller
{
    private BidService $bidService;
    private BidRepository $bidRepository;

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
        BidRepository $bidRepository,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->bidService = $bidService;
        $this->bidRepository = $bidRepository;
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
        $bidDTO = $this->bidService->accept($id);
        if ($bidDTO->result) {
            Yii::$app->session->setFlash('success', 'Заявка выбрана.');
        }

        $this->redirect(['task/view', 'id' => $bidDTO->bid->task_id]);
    }

    public function actionDecline($id)
    {
        $bidDTO = $this->bidService->decline($id);
        if ($bidDTO->result) {
            Yii::$app->session->setFlash('success', 'Заявка отклонена.');
        }

        $this->redirect(['task/view', 'id' => $bidDTO->bid->task_id]);
    }
}