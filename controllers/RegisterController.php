<?php

namespace app\controllers;

use app\forms\ClientRegisterForm;
use app\forms\EmployeeRegisterForm;
use app\models\Employee;
use app\repositories\CategoryRepository;
use app\repositories\CityRepository;
use app\services\dto\ClientDTO;
use app\services\dto\ContactDTO;
use app\services\dto\EmployeeDTO;
use app\services\dto\UserDTO;
use app\services\RegisterService;
use Yii;
use yii\filters\AccessControl;

class RegisterController extends \yii\web\Controller
{
    private CityRepository $cityRepository;
    private RegisterService $registerService;
    private CategoryRepository $categoryRepository;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function __construct(
        $id,
        $module,
        CityRepository $cityRepository,
        RegisterService $registerService,
        CategoryRepository $categoryRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config = []);
        $this->cityRepository = $cityRepository;
        $this->registerService = $registerService;
        $this->categoryRepository = $categoryRepository;
    }

    public function actionEmployee()
    {
        $model = new EmployeeRegisterForm($this->categoryRepository, $this->cityRepository);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            $this->registerService->createEmployee(
//                new EmployeeDTO(
//                    new UserDTO($model->name, $model->email, $model->password, $model->birthday, $model->city_id),
//                    $model->about,
//                    new ContactDTO($model->phone, $model->telegram),
//                    $model->categories_id
//                )
//            );
            $this->registerService->createEmployee($model);
            Yii::$app->session->setFlash('success', '?????????????????????? ??????????????????????????????.');
            $this->redirect(['site/login']);
        }
        return $this->render('employee', [
            'model' => $model,
        ]);
    }

    public function actionClient()
    {
        $model = new ClientRegisterForm($this->cityRepository);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->registerService->createClient(
                new ClientDTO(
                    new UserDTO($model->name, $model->email, $model->password, $model->birthday, $model->city_id)
                )
            );
            Yii::$app->session->setFlash('success', '?????????????????????? ??????????????????????????????.');
            $this->redirect(['site/login']);
        }
        return $this->render('client', [
            'model' => $model,
        ]);
    }
}
