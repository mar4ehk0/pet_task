<?php

namespace app\services;

use app\forms\CreateBidForm;
use app\models\Bid;
use app\repositories\BidRepository;
use app\services\dto\BidResultDTO;

class BidService
{
    private BidRepository $bidRepository;
    private TransactionManager $transactionManager;
    private TaskService $taskService;

    public function __construct(
        BidRepository $bidRepository,
        TaskService $taskService,
        TransactionManager $transactionManager
    ) {
        $this->bidRepository = $bidRepository;
        $this->transactionManager = $transactionManager;
        $this->taskService = $taskService;
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

    public function accept(int $id): Bid
    {
        $bid = $this->bidRepository->find($id);
        $func = $this->taskService->startTask($bid);

        $this->transactionManager->execute(function () use ($func) {
            $func();
        });

        return $bid;
    }

    public function decline(int $id): Bid
    {
        $bid = $this->bidRepository->find($id);
        $bid->decline();
        $this->transactionManager->execute(function () use ($bid) {
            $this->bidRepository->save($bid);
        });
        return $bid;
    }
}
