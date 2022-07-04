<?php

namespace app\rbac;

use app\models\Bid;
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

    public const PERMISSION_CREATE_TASK = 'createTask';
    public const PERMISSION_COMPLETE_TASK = 'completeTask';
    public const PERMISSION_VIEW_TASK = 'viewTask';
    public const PERMISSION_CANCEL_TASK = 'cancelTask';
    public const PERMISSION_START_TASK = 'startTask';
    public const PERMISSION_ABORT_TASK = 'abortTask';

    public const PERMISSION_CREATE_BID = 'createBid';
    public const PERMISSION_VIEW_ALL_BIDS = 'viewAllBids';
    public const PERMISSION_VIEW_OWN_BID = 'viewOwnBid';
    public const PERMISSION_DECLINE_BID = 'declineBid';

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

    public function isUserClient(): bool
    {
        return Yii::$app->user->can(self::CLIENT);
    }

    public function isUserEmployee(): bool
    {
        return Yii::$app->user->can(self::EMPLOYEE);
    }

    public function canShowBidButton(User $user, Task $task): bool
    {
        // @TODO надо создать rbac Rule, которое будет проверять не отлкикался ли уже текущий пользователь на
        // данную задачу и проверять что пользователь имеет роль employee
        // Yii::$app->user->can('createBid')
        return Yii::$app->user->can(self::EMPLOYEE)
            && Yii::$app->user->can(self::PERMISSION_CREATE_BID, ['user' => $user, 'task' => $task]);
    }

    public function canShowCancelButton(User $user, Task $task): bool
    {
        // @TODO надо создать rbac Rule, которое будет проверять что никто не откликнулся на эут задачу
        // и проверть что пользователь является владельцем задачи
        // Yii::$app->user->can('createBid')

        return Yii::$app->user->can(self::CLIENT)
            && Yii::$app->user->can(self::PERMISSION_CANCEL_TASK, ['task' => $task]);
    }

    public function canShowCompleteButton(User $user, Task $task): bool
    {

        // @TODO надо создать rbac Rule, надо проверить что задача находится в статсу STATUS_IN_WORK
        // и проверть что пользователь является владельцем задачи
        // Yii::$app->user->can('createBid')
        return Yii::$app->user->can(self::CLIENT)
            && Yii::$app->user->can(self::PERMISSION_COMPLETE_TASK, ['task' => $task]);
    }

    public function canShowAbortButton(User $user, Task $task)
    {
        // @TODO надо создать rbac Rule, надо проверить что задача находится в статсу STATUS_IN_WORK
        // и проверть что пользователя выбрали исполнителем
        // Yii::$app->user->can('createBid')
        return Yii::$app->user->can(self::EMPLOYEE)
            && Yii::$app->user->can(self::PERMISSION_ABORT_TASK, ['task' => $task]);
    }

    public function canShowBid(Bid $bid): bool
    {
        if (Yii::$app->user->can(self::CLIENT)) {
            return Yii::$app->user->can(self::PERMISSION_VIEW_ALL_BIDS, ['bid' => $bid]);
        }
        return Yii::$app->user->can(self::PERMISSION_VIEW_OWN_BID, ['bid' => $bid]);
    }

    public function canShowButtonAcceptBid(Bid $bid): bool
    {
        return Yii::$app->user->can(self::CLIENT)
            && Yii::$app->user->can(self::PERMISSION_START_TASK, ['bid' => $bid]);
    }

    public function canShowButtonDeclineBid(Bid $bid): bool
    {
        return Yii::$app->user->can(self::CLIENT)
            && Yii::$app->user->can(self::PERMISSION_DECLINE_BID, ['bid' => $bid]);
    }
}
