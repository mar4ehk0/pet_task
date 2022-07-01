<?php

namespace app\rbac\rules;

use app\models\Bid;
use app\models\Task;
use yii\rbac\Rule;

class CanDeclineBid  extends Rule
{
    public $name = 'canDeclineBid';

    /**
     * @param int $userId the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($userId, $item, $params)
    {
        if (!isset($params['bid'])) {
            return false;
        }

        /** @var Bid $bid */
        $bid = $params['bid'];

        /** @var Task $task */
        $task = $bid->task;

        return $task->status === Task::STATUS_NEW && !$bid->is_declined;
    }
}