<?php

namespace app\helpers;

use app\models\Task;

class TaskView
{
    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getId(): int
    {
        return $this->task->id;
    }

    public function getPrice(): string
    {
        return ViewHelper::getPrice($this->task->price);
    }

    public function getTitle(): string
    {
        return $this->task->title;
    }

    public function getDescription(): string
    {
        return $this->task->description;
    }

    public function getLocation(): string
    {
        if ($this->task->is_remote) {
            return 'Удаленная работа';
        }

        return $this->task->location;
    }

    public function getCategory(): string
    {
        return $this->task->category->human_name;
    }

    public function getPublicationDate(): string
    {
        $date = new \DateTime($this->task->created);
        return ViewHelper::getRelativeTime($date);
    }

    public function getDeadline(): string
    {
       $deadline = new \DateTime($this->task->deadline);

       return $deadline->format('Y, d F, H:i');
    }

    public function getStatus(): string
    {
        $list = ViewHelper::getListStatusTask();
        return $list[$this->task->status];

    }





}