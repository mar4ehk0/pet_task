<?php

namespace app\helpers;

use app\models\Bid;
use app\models\buttons\bid\AbstractButtonBid;
use app\models\buttons\bid\AcceptButton;
use app\models\buttons\bid\DeclineButton;
use app\rbac\RBACManager;

class BidView
{
    private Bid $bid;
    private RBACManager $rbacManager;
    /** @var AbstractButtonBid[] */
    private array $buttons;

    public function __construct(Bid $bid)
    {
        $this->bid = $bid;
        $this->rbacManager = new RBACManager();
        
        $this->createsButtons();
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
        return $this->rbacManager->canShowBid($this->bid);
    }

    public function getButtons(): array
    {
        return $this->buttons;
    }

    private function createsButtons(): void
    {
        $buttons = [];
        if ($this->rbacManager->canShowButtonAcceptBid($this->bid)) {
            $buttons[] = new AcceptButton($this->bid);
        }
        if ($this->rbacManager->canShowButtonDeclineBid($this->bid)) {
            $buttons[] = new DeclineButton($this->bid);
        }
        $this->buttons = $buttons;
    }


}