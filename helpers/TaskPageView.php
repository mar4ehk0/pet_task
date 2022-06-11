<?php

namespace app\helpers;

use app\models\buttons\ButtonAbstract;
use app\models\buttons\ButtonFactory;
use app\models\File;
use app\models\Task;
use app\models\User;

class TaskPageView
{
    private Task $task;
    private User $user;
    private ?ButtonAbstract $button;
    private TaskView $taskView;

    public function __construct(Task $task, User $user)
    {
        $this->task = $task;
        $this->user = $user;

        $this->taskView = new TaskView($task);

        $this->button = ButtonFactory::create($user, $task);
    }

    public function getButton(): ?ButtonAbstract
    {
        return $this->button;
    }

    public function getId(): int
    {
        return $this->taskView->getId();
    }

    public function getPrice(): string
    {
        return $this->taskView->getPrice();
    }

    public function getTitle(): string
    {
        return $this->taskView->getTitle();
    }

    public function getDescription(): string
    {
        return $this->taskView->getDescription();
    }

    public function getLocation(): string
    {
        return $this->taskView->getLocation();
    }

    public function getCategory(): string
    {
        return $this->taskView->getCategory();
    }

    public function getPublicationDate(): string
    {
        return $this->taskView->getPublicationDate();
    }

    public function getDeadline(): string
    {
        return $this->taskView->getDeadline();
    }

    public function getStatus(): string
    {
        return $this->taskView->getStatus();
    }

    /**
     * @return FileView[]
     */
    public function getFiles(): array
    {
        if (empty($this->task->files)) {
            return [];
        }

        $result = [];
        /** @var File $file */
        foreach ($this->task->files as $file) {
            $result[] = new FileView($file);
        }

        return $result;
    }
}