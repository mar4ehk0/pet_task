<?php

namespace app\models\buttons;

use app\rbac\RBACManager;
use yii\base\Model;

class ButtonFactory extends Model
{
    public static function create($user, $task): ?ButtonAbstract
    {
        $rbacManager = new RBACManager();

        if ($rbacManager->canShowBidButton($user, $task)) {
            return new BidButton($task);
        }
        if ($rbacManager->canShowCancelButton($user, $task)) {
            return new CancelButton($task);
        }
        if ($rbacManager->canShowAbortButton($user, $task)) {
            return new AbortButton($task);
        }
        if ($rbacManager->canShowCompleteButton($user, $task)) {
            return new CompleteButton($task);
        }

        return null;
    }
}