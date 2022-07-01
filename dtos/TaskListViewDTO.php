<?php

namespace app\dtos;

use app\helpers\TaskView;
use app\models\Task;
use yii\data\Pagination;

//@TODO перенести этот класс в helpers и переименновать в TaskListView
class TaskListViewDTO
{
    /**
     * @var TaskView[]
     */
    public array $tasks;
    public Pagination $pages;

    /**
     * @param Task[] $tasks
     * @param Pagination $pages
     */
    public function __construct(array $tasks, Pagination $pages)
    {
        $this->tasks = [];
        foreach ($tasks as $task) {
            $this->tasks[] = new TaskView($task);
        }
        $this->pages = $pages;
    }
}
