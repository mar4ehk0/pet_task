<?php

namespace app\helpers;

use app\models\File;
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
        if (empty($this->task->price)) {
            return 'Цена не определена';
        }

        return $this->task->price . '₽';
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
        $current = New \DateTime();
        $interval = $current->diff($date);
        // @TODO plural для вывода дат
        if (!empty($interval->y)) {
            return $interval->y . 'лет назад';
        }

        if (!empty($interval->m)) {
            return $interval->m . 'лет назад';
        }

        if (!empty($interval->d)) {
            return $interval->d . 'дней назад';
        }

        if (!empty($interval->h)) {
            return $interval->d . 'часов назад';
        }

        if (!empty($interval->m)) {
            return $interval->m . 'минут назад';
        }

        return 'недавно';
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