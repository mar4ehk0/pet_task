<?php

namespace app\rbac\rules;

use app\models\Task;
use yii\rbac\Rule;

class CanAbortTask extends Rule
{
    public $name = 'canAbortTask';

    /**
     * @param int $userId the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($userId, $item, $params)
    {
        if (!isset($params['user'], $params['task'])) {
            return false;
        }

        /** @var $params['user'] User */
        $user = $params['user'];
        /** @var $params['task'] Task */
        $task = $params['task'];

        if ($task->status !== Task::STATUS_IN_WORK || $task->employee_id !== $userId) {
            return false;
        }
        return true;
    }
}