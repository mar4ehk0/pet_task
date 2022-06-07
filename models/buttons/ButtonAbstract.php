<?php

namespace app\models\buttons;

use app\models\Task;
use yii\base\Model;

abstract class ButtonAbstract extends Model
{
    protected Task $task;

    public function __construct(Task $task, $config = [])
    {
        parent::__construct($config);
        $this->task = $task;
    }

    abstract public function getName(): string;
    abstract public function getUrl(): string;

}