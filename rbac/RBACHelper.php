<?php

namespace app\rbac;

use app\rbac\rules\CanAbortTask;
use app\rbac\rules\CanBid;
use app\rbac\rules\CanCancelTask;
use app\rbac\rules\CanCompleteTask;
use app\rbac\rules\CanStartTask;
use app\rbac\rules\CanViewAllBids;
use app\rbac\rules\CanViewOwnBid;

class RBACHelper
{
    public static function getClientPermissions(): array
    {
        return [
            RBACManager::PERMISSION_CREATE_TASK => null,
            RBACManager::PERMISSION_VIEW_TASK => null,
            RBACManager::PERMISSION_COMPLETE_TASK => new CanCompleteTask(),
            RBACManager::PERMISSION_CANCEL_TASK => new CanCancelTask(),
            RBACManager::PERMISSION_START_TASK => new CanStartTask(),
            RBACManager::PERMISSION_VIEW_ALL_BIDS => new CanViewAllBids(),
        ];
    }

    public static function getEmployeePermissions(): array
    {
        return [
            RBACManager::PERMISSION_CREATE_BID => new CanBid(),
            RBACManager::PERMISSION_ABORT_TASK => new CanAbortTask(),
            RBACManager::PERMISSION_VIEW_TASK => null,
            RBACManager::PERMISSION_VIEW_OWN_BID => new CanViewOwnBid(),
        ];
    }
}