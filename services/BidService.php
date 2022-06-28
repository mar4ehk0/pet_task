<?php

namespace app\services;

use app\forms\CreateBidForm;
use app\models\Bid;
use app\repositories\BidRepository;

class BidService
{
    private BidRepository $bidRepository;
    private TransactionManager $transactionManager;

    public function __construct(BidRepository $bidRepository, TransactionManager $transactionManager)
    {
        $this->bidRepository = $bidRepository;
        $this->transactionManager = $transactionManager;
    }

    public function createBid(CreateBidForm $bidForm): Bid
    {
        $bid = Bid::create(
            $bidForm->getEmployeeId(),
            $bidForm->getDescription(),
            $bidForm->getPrice(),
            $bidForm->getTaskId()
        );

        $this->transactionManager->execute(function () use ($bid) {
            $this->bidRepository->add($bid);
        });

        return $bid;
    }

}