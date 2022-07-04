<?php

namespace app\models\buttons\actions;

use app\models\Task;
use app\repositories\TaskRepository;

abstract class AbstractTaskAction
{
    protected Task $task;
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function do(): \Closure
    {
        $this->task = $this->taskRepository->find($this->getTaskId());
        $task = $this->task;
        $this->action();
        return function () use ($task) {
            $this->taskRepository->save($task);
        };
    }

    abstract protected function getTaskId(): int;
    abstract protected function action(): void;
}