<?php

namespace app\helpers;

use app\dtos\TaskListViewDTO;
use app\forms\FindTaskForm;

class SearchTaskView
{
    private FindTaskForm $findTaskForm;
    private TaskListViewDTO $data;

    public function __construct(FindTaskForm $findTaskForm, TaskListViewDTO $data)
    {
        $this->findTaskForm = $findTaskForm;
        $this->data = $data;
    }

    public function getForm(): FindTaskForm
    {
        return $this->findTaskForm;
    }

    public function getData(): TaskListViewDTO
    {
        return $this->data;
    }
}