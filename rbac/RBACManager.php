<?php

namespace app\rbac;

use app\models\Client;
use app\models\Employee;
use app\models\Task;
use app\models\User;
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

    public function canShowBidButton(User $user, Task $task): bool
    {
        if (!$task->status !== Task::STATUS_NEW) {
            return false;
        }
        // @TODO надо создать rbac Rule, которое будет проверять не отлкикался ли уже текущий пользователь на данную задачу
        // и проверять что пользователь имеет роль employee
        // Yii::$app->user->can('createBid')
    }

    public function canShowCancelButton(User $user, Task $task)
    {
        if (!$task->status !== Task::STATUS_NEW) {
            return false;
        }
        // @TODO надо создать rbac Rule, которое будет проверять что никто не откликнулся на эут задачу
        // и проверть что пользователь является владельцем задачи
        // Yii::$app->user->can('createBid')
    }

    public function canShowCompleteButton(User $user, Task $task)
    {
        if (!$task->status !== Task::STATUS_IN_WORK) {
            return false;
        }
        // @TODO надо создать rbac Rule, надо проверить что задача находится в статсу STATUS_IN_WORK
        // и проверть что пользователь является владельцем задачи
        // Yii::$app->user->can('createBid')
    }

    public function canShowAbortButton(User $user, Task $task)
    {
        if (!$task->status !== Task::STATUS_IN_WORK) {
            return false;
        }
        // @TODO надо создать rbac Rule, надо проверить что задача находится в статсу STATUS_IN_WORK
        // и проверть что пользователя выбрали исполнителем
        // Yii::$app->user->can('createBid')
    }
}