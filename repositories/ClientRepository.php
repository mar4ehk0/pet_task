<?php

namespace app\repositories;

use app\models\Client;
use app\repositories\exceptions\NotFoundException;

class ClientRepository
{
    public function find(int $id): Client
    {
        if (!$client = Client::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $client;
    }

    public function add(Client $client): bool
    {
        if (!$client->getIsNewRecord()) {
            throw new \RuntimeException('Adding existing model.');
        }
        if (!$client->insert(false)) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }

    public function save(Client $client): bool
    {
        if ($client->getIsNewRecord()) {
            throw new \RuntimeException('Saving new model.');
        }
        if ($client->update(false) === false) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }

    public function delete(Client $client): bool
    {
        if (!$client->delete()) {
            throw new \RuntimeException('Deleting error.');
        }

        return true;
    }
}