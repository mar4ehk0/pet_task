<?php

namespace app\repositories;

use app\dtos\TaskListViewDTO;
use app\forms\FindTaskForm;
use app\models\Task;
use app\repositories\exceptions\NotFoundException;
use yii\data\Pagination;

class TaskRepository
{

    private const LIMIT_TASK_PER_PAGE = 5;

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

    public function findByQuery(FindTaskForm $model): TaskListViewDTO
    {
        $query = Task::find();
        if ($period = $model->getPeriod()) {
            $query->andWhere(['created' => ['between', $period->from, $period->to]]);
        }
        if ($categoriesId = $model->getCategoriesId()) {
            $query->andWhere(['category_id' => $categoriesId]);
        }
        $status = $model->getStatus();
        if (!is_null($status)) {
            $query->andWhere(['status' => $status]);
        }
        $client_id = $model->getClientId();
        if (!is_null($client_id)) {
            $query->andWhere(['client_id' => $client_id]);
        }

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(self::LIMIT_TASK_PER_PAGE);
        $results = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->indexBy('id')->all();

        return new TaskListViewDTO($results, $pages);
    }
}