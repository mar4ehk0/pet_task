<?php

namespace app\models\buttons;

use yii\helpers\Url;

class CancelButton extends ButtonAbstract
{

    public function getName(): string
    {
        return 'Отменить';
    }

    public function getUrl(): string
    {
        return Url::to(['task/cancel', ['id' => $this->task->id]]);
    }
}