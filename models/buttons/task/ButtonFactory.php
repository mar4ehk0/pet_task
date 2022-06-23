<?php

namespace app\models\buttons\task;

use app\rbac\RBACManager;
use yii\base\Model;

class ButtonFactory extends Model
{
    public static function create($user, $task): ?AbstractButtonTask
    {
        $rbacManager = new RBACManager();

        if ($rbacManager->canShowBidButton($user, $task)) {
            return new BidButtonTask($task);
        }
        if ($rbacManager->canShowCancelButton($user, $task)) {
            return new CancelButtonTask($task);
        }
        if ($rbacManager->canShowAbortButton($user, $task)) {
            return new AbortButtonTask($task);
        }
        if ($rbacManager->canShowCompleteButton($user, $task)) {
            return new CompleteButtonTask($task);
        }

        return null;
    }
}