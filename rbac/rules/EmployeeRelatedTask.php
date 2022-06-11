<?php

namespace app\rbac\rules;

use yii\rbac\Rule;

class EmployeeRelatedTask extends Rule
{
    public $name = 'isEmployeeRelatedTask';

    /**
     * @param int $userId the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($userId, $item, $params)
    {
        /** @var $params['task'] Task */
        return isset($params['task']) && $params['task']->employee_id == $userId;
    }
}