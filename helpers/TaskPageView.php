<?php

namespace app\helpers;

use app\models\buttons\task\AbstractButtonTask;
use app\models\buttons\task\ButtonFactory;
use app\models\File;
use app\models\Task;
use app\models\User;

class TaskPageView
{
    private Task $task;
    private User $user;
    private ?AbstractButtonTask $button;
    private TaskView $taskView;
    private ListBidView $bidsListView;

    public function __construct(Task $task, User $user, ListBidView $bidsListView)
    {
        $this->task = $task;
        $this->user = $user;

        $this->taskView = new TaskView($task);

        $this->button = ButtonFactory::create($user, $task);
        $this->bidsListView = $bidsListView;
    }

    public function getButton(): ?AbstractButtonTask
    {
        return $this->button;
    }

    public function getButtonTitle(): string
    {
        return $this->button ? $this->button->getName() : '';
    }

    public function getButtonUrl(): string
    {
        return $this->button ? $this->button->getUrl() : '';
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

    /**
     * @return BidView[] array
     */
    public function getListBidView(): array
    {
        return $this->bidsListView->getAllowedListBid();
    }
}