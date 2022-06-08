<?php

namespace app\controllers;

use app\forms\ClientRegisterForm;
use app\forms\EmployeeRegisterForm;
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

    public function __construct($id, $module, CityRepository $cityRepository, RegisterService $registerService, $config = [])
    {
        $this->cityRepository = $cityRepository;
        $this->registerService = $registerService;
        parent::__construct($id, $module, $config = []);
    }

    public function actionEmployee()
    {
        $model = new EmployeeRegisterForm($this->cityRepository);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->registerService->createEmployee(
                new EmployeeDTO(
                    new UserDTO($model->name, $model->email, $model->password, $model->birthday, $model->city_id),
                    $model->about,
                    new ContactDTO($model->phone, $model->telegram)
                )
            );
            Yii::$app->session->setFlash('success', 'Исполнитель зарегестрирован.');
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
            Yii::$app->session->setFlash('success', 'Исполнитель зарегестрирован.');
        }
        return $this->render('client', [
            'model' => $model,
        ]);
    }

}
