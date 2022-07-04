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
        $this->task = $this->taskRepository->find($this->getTaskId());
    }

    public function do(): \Closure
    {
        $task = $this->task;
        $this->action();
        return function () use ($task) {
            $this->taskRepository->save($task);
        };
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    abstract protected function getTaskId(): int;
    abstract protected function action(): void;
}
