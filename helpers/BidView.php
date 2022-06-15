<?php

namespace app\helpers;

use app\models\Bid;
use app\rbac\RBACManager;

class BidView
{
    private Bid $bid;

    public function __construct(Bid $bid)
    {
        $this->bid = $bid;
    }

    public function getEmployeeName(): string
    {
        return $this->bid->employee->user->name;
    }

    public function getEmployeeRating(): float
    {
        return ViewHelper::convertRating($this->bid->employee->rating);
    }

    public function getPublicationDate(): string
    {
        $date = new \DateTime($this->bid->created);
        return ViewHelper::getRelativeTime($date);
    }

    public function getDescription(): string
    {
        return $this->bid->description;
    }

    public function getPrice(): string
    {
        return ViewHelper::getPrice($this->bid->price);
    }

    public function getNumFeedback(): string
    {
        // @TODO добавить feedbacks return $this->bid->employee->feedbacks;
        return '5 отзывов';
    }

    public function canView(): bool
    {
        $rbacManager = new RBACManager();
        return $rbacManager->canShowBid($this->bid);
    }
}