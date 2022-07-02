<?php

namespace app\repositories;

use app\models\Feedback;
use app\repositories\exceptions\NotFoundException;

class FeedbackRepository
{
    public function find(int $id): Feedback
    {
        if (!$feedback = Feedback::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $feedback;
    }

    public function add(Feedback $feedback): bool
    {
        if (!$feedback->getIsNewRecord()) {
            throw new \RuntimeException('Adding existing model.');
        }

        if (!$feedback->insert(false)) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }

    public function save(Feedback $feedback): bool
    {
        if ($feedback->getIsNewRecord()) {
            throw new \RuntimeException('Saving new model.');
        }
        if ($feedback->update(false) === false) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }

    public function delete(Feedback $feedback): bool
    {
        if (!$feedback->delete()) {
            throw new \RuntimeException('Deleting error.');
        }

        return true;
    }
}
