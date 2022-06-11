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
}