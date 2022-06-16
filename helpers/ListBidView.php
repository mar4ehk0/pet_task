<?php

namespace app\helpers;

use app\models\Bid;

class ListBidView
{
    /**
     * @param BidView[] $bidsView
     */
    private array $listBidView;

    /**
     * @param Bid[] $bids
     */
    public function __construct(array $bids)
    {
        $this->listBidView = [];
        foreach ($bids as $bid) {
            $this->listBidView[] = new BidView($bid);
        }
    }

    /**
     * @return BidView[] array
     */
    public function getAllowedListBid(): array
    {
        $result = [];
        foreach ($this->listBidView as $bidView) {
            /** @var BidView $bidView */
            if ($bidView->canView()) {
                $result[] = $bidView;
            }
        }

        return $result;
    }
}