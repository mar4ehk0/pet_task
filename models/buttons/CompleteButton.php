<?php

namespace app\models\buttons;

use yii\helpers\Url;

class CompleteButton extends ButtonAbstract
{
    public function getName(): string
    {
        return 'Завершить';
    }

    public function getUrl(): string
    {
        return Url::to(['task/cancel', 'id' => $this->task->id]);
    }
}