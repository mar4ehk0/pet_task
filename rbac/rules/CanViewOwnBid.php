<?php

namespace app\rbac\rules;

use app\models\Bid;
use yii\rbac\Rule;

class CanViewOwnBid extends Rule
{
    public $name = 'canViewOwnBid';

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
        if ($bid->employee_id !== $userId) {
            return false;
        }
        return true;
    }
}