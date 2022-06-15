<?php

namespace app\controllers;

use app\forms\FindTaskForm;
use app\rbac\RBACManager;
use app\repositories\CategoryRepository;
use app\repositories\UserRepository;
use app\services\TaskService;
use app\services\UserService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\forms\LoginForm;
use app\forms\ContactForm;

class SiteController extends Controller
{

    private UserRepository $userRepository;
    private UserService $userService;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['*'],
                    ],
                ],
            ],
        ];
    }


    public function __construct($id, $module, UserRepository $userRepository, UserService $userService, $config = [])
    {
        parent::__construct($id, $module, $config = []);
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function actionIndex()
    {
        // если зарегестрированный то вывод страницы для поиска работы - роль исполнитель
        // если зарегестрированный то вывод страницы со списком всех заказов - роль заказчик
        // если не зарегестрированный то вывод страницы с текстом

        $rbacManager = new RBACManager();
        if ($rbacManager->isUserEmployee()) {
            // если зарегестрированный то вывод страницы для поиска работы - роль исполнитель
            $this->redirect(['task/employees']);
        } elseif ($rbacManager->isUserClient()) {
            // если зарегестрированный то вывод страницы со списком всех заказов - роль заказчик
            $this->redirect(['task/clients']);
        } else {
            return $this->render('notlogin');
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }

        $model = new LoginForm($this->userRepository);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->userService->login($model->email);
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
