<?php

namespace app\models\buttons\task;

use yii\helpers\Url;

class AbortButtonTask extends AbstractButtonTask
{
    public function getName(): string
    {
        return 'Отказаться';
    }

    public function getUrl(): string
    {
        return Url::to(['task/abort', 'id' => $this->task->id]);
    }
}