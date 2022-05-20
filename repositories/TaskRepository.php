<?php

namespace app\repositories;

use app\models\Task;
use app\repositories\exceptions\NotFoundException;

class TaskRepository
{
    public function find(int $id): Task
    {
        if (!$task = Task::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $task;
    }

    public function add(Task $task): bool
    {
        if (!$task->getIsNewRecord()) {
            throw new \RuntimeException('Adding existing model.');
        }
        if (!$task->insert(false)) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }

    public function save(Task $task): bool
    {
        if ($task->getIsNewRecord()) {
            throw new \RuntimeException('Saving new model.');
        }
        if ($task->update(false) === false) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }

    public function delete(Task $task): bool
    {
        if (!$task->delete()) {
            throw new \RuntimeException('Deleting error.');
        }

        return true;
    }
}