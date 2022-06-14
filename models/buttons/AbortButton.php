<?php

namespace app\models\buttons;

use yii\helpers\Url;

class AbortButton extends ButtonAbstract
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