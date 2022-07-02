<?php

namespace app\models\buttons\task;

use yii\helpers\Url;

class CompleteButtonTask extends AbstractButtonTask
{
    public function getName(): string
    {
        return 'Завершить';
    }

    public function getUrl(): string
    {
        return Url::to(['feedback/create', 'task_id' => $this->task->id]);
    }
}
