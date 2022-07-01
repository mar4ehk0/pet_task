<?php

namespace app\commands;

use app\rbac\RBACHelper;
use app\rbac\RBACManager;
use Yii;
use yii\console\Controller;
use yii\rbac\DbManager;
use yii\rbac\Role;
use yii\rbac\Rule;

class RbacController extends Controller
{
    public function actionIndex(): void
    {
        /**
         * @psalm-suppress UndefinedClass
         */
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // Creates roles
        $client = $auth->createRole(RBACManager::CLIENT);
        $auth->add($client);
        $employee = $auth->createRole(RBACManager::EMPLOYEE);
        $auth->add($employee);

        $clientPermissions = RBACHelper::getClientPermissions();
        $this->createPermissions($auth, $client, $clientPermissions);

        $employeePermissions = RBACHelper::getEmployeePermissions();
        $this->createPermissions($auth, $employee, $employeePermissions);

        $this->stdout('Done. Create Roles and Permissions' . PHP_EOL);
    }

    private function createPermissions(DbManager $auth, Role $role, array $clientPermissions): void
    {
        foreach ($clientPermissions as $namePermission => $value) {
            if (is_null($value)) {
                if (!$permission = $auth->getPermission($namePermission)) {
                    $permission = $auth->createPermission($namePermission);
                    $auth->add($permission);
                }
                $auth->addChild($role, $permission);
            }
            if ($value instanceof Rule) {
                $auth->add($value);
                $permission = $auth->createPermission($namePermission);
                $permission->ruleName = $value->name;
                $auth->add($permission);
                $auth->addChild($role, $permission);
            }
        }
    }
}
