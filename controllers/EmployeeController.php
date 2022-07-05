<?php

namespace app\controllers;

use app\helpers\EmployeeView;
use app\repositories\CityRepository;
use app\repositories\EmployeeRepository;
use app\repositories\UserRepository;

class EmployeeController extends \yii\web\Controller
{
    private EmployeeRepository $employeeRepository;
    private UserRepository $userRepository;
    private CityRepository $cityRepository;

    public function __construct(
        $id,
        $module,
        EmployeeRepository $employeeRepository,
        UserRepository $userRepository,
        CityRepository $cityRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->employeeRepository = $employeeRepository;
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
    }

    public function index($id)
    {
        $employeeView = new EmployeeView($id, $this->employeeRepository, $this->userRepository, $this->cityRepository);
    }
}
