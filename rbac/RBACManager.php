<?php

namespace app\rbac;

use app\models\Client;
use app\models\Employee;
use Yii;
use yii\rbac\DbManager;
use yii\rbac\Role;

class RBACManager
{
    public const CLIENT = 'client';
    public const EMPLOYEE = 'employee';

    private DbManager $auth;
    private Role $roleClient;
    private Role $roleEmployee;


    public function __construct()
    {
        $this->auth = Yii::$app->authManager;
        $this->roleClient = $this->getClientRole();
        $this->roleEmployee = $this->getEmployeeRole();
    }

    public function assignClient(Client $client): void
    {
        $this->auth->assign($this->roleClient, $client->user_id);
    }

    public function assignEmployee(Employee $employee): void
    {
        $this->auth->assign($this->roleEmployee, $employee->user_id);
    }

    public function getClientRole(): Role
    {
        return $this->auth->getRole(self::CLIENT);
    }

    public function getEmployeeRole(): Role
    {
        return $this->auth->getRole(self::EMPLOYEE);
    }
}