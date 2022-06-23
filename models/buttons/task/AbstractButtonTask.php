<?php

namespace app\models\buttons\task;

use app\models\buttons\AbstractButton;
use app\models\Task;

abstract class AbstractButtonTask extends AbstractButton
{
    protected Task $task;

    public function __construct(Task $task, $config = [])
    {
        parent::__construct($config);
        $this->task = $task;
    }

}