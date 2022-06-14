<?php

namespace app\rbac\rules;

use app\models\Task;
use app\repositories\BidRepository;
use app\repositories\exceptions\NotFoundException;
use yii\rbac\Rule;

class CanBid extends Rule
{
    public $name = 'canBid';

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

        if ($task->status !== Task::STATUS_NEW) {
            return false;
        }

        $bidRepository = new BidRepository();
        try {
            $bidRepository->findByTaskIdAndEmployeeId($task->id, $user->id);
            return false;
        } catch (NotFoundException $exception) {
            return true;
        }
    }
}