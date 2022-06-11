<?php

namespace app\commands;

use app\rbac\RBACManager;
use app\rbac\rules\ClientRelatedTask;
use app\rbac\rules\EmployeeRelatedTask;
use Yii;
use yii\console\Controller;
use yii\rbac\Role;
use yii\rbac\Rule;

class RbacController extends Controller
{
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // Creates roles
        $client = $auth->createRole(RBACManager::CLIENT);
        $auth->add($client);
        $employee = $auth->createRole(RBACManager::EMPLOYEE);
        $auth->add($employee);

        // Creates permissions for tasks
        $taskPermissions = ['createTask', 'completeTask', 'viewTask', 'cancelTask', 'startTask', 'abortTask'];

        // Create permissions for bids
        $bidPermissions = ['createBid', 'viewBid'];

        $permission = array_merge($taskPermissions, $bidPermissions);
        foreach ($permission as $permissionName) {
            $permission = $auth->createPermission($permissionName);
            $auth->add($permission);
        }

        // Only client can create Task
        $this->addRoleSpecialPermission($auth, $client, 'createTask');
        // Only employee can create Bid
        $this->addRoleSpecialPermission($auth, $employee, 'createBid');
        // Only client can see all Bids
        $this->addRoleSpecialPermission($auth, $client, 'viewBid');

        // All can see Task
        $this->addRoleSpecialPermission($auth, $client, 'viewTask');
        $this->addRoleSpecialPermission($auth, $employee, 'viewTask');

        $employeeRelatedTask = new EmployeeRelatedTask;
        $auth->add($employeeRelatedTask);
        $clientRelatedTask = new ClientRelatedTask;
        $auth->add($clientRelatedTask);

        // Permissions with rule for client.
        $permissionsWithRule = [
            'completeTask' => 'completeOwnTask',
            'cancelTask' => 'cancelOwnTask',
            'startTask' => 'startOwnTask'
        ];

        $this->setPermissions($permissionsWithRule, $auth, $clientRelatedTask, $client);

        // Permissions with rule for employee.
        $permissionsWithRule = [
            'abortTask' => 'abortOwnTask',
//            'viewBid' => 'viewOwnBid',
        ];
        $this->setPermissions($permissionsWithRule, $auth, $employeeRelatedTask, $employee);

        $this->stdout('Done. Create Roles and Permissions' . PHP_EOL);

    }

    private function setPermissions(array $permissions, $auth, Rule $rule, Role $role): void
    {
        foreach ($permissions as $existNamePermission => $newNamePermission) {
            $newPermission = $auth->createPermission($newNamePermission);
            $newPermission->ruleName = $rule->name;
            $auth->add($newPermission);

            $existPermission = $auth->getPermission($existNamePermission);
            $auth->addChild($newPermission, $existPermission);
            $auth->addChild($role, $newPermission);
        }
    }

    private function addRoleSpecialPermission($auth, Role $client, string $namePermission): void
    {
        $permission = $auth->getPermission($namePermission);
        $auth->addChild($client, $permission);
    }

}