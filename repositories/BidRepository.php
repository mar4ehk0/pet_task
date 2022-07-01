<?php

namespace app\repositories;

use app\models\Bid;
use app\repositories\exceptions\NotFoundException;

class BidRepository
{
    public function find(int $id): Bid
    {
        if (!$bid = Bid::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $bid;
    }

    public function findByTaskIdAndEmployeeId(int $task_id, int $employee_id): Bid
    {
        if (!$bid = Bid::findOne(['employee_id' => $employee_id, 'task_id' => $task_id])) {
            throw new NotFoundException('Model not found.');
        }
        return $bid;
    }

    public function findSelectedByTaskId(int $task_id): Bid
    {
        if (!$bid = Bid::findOne(['is_selected' => true, 'task_id' => $task_id])) {
            throw new NotFoundException('Model not found.');
        }
        return $bid;
    }

    public function add(Bid $bid): bool
    {
        if (!$bid->getIsNewRecord()) {
            throw new \RuntimeException('Adding existing model.');
        }

        if (!$bid->insert(false)) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }

    public function save(Bid $bid): bool
    {
        if ($bid->getIsNewRecord()) {
            throw new \RuntimeException('Saving new model.');
        }
        if ($bid->update(false) === false) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }

    public function delete(Bid $bid): bool
    {
        if (!$bid->delete()) {
            throw new \RuntimeException('Deleting error.');
        }

        return true;
    }

    public function findAllByTaskId($task_id): array
    {
        if (!$bids = Bid::findAll(['task_id' => $task_id])) {
            return [];
        }
        return $bids;
    }
}
