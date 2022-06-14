<?php

namespace app\models\buttons;

use app\models\Task;
use yii\helpers\Url;

class BidButton extends ButtonAbstract
{

    public function getName(): string
    {
        return 'Откликнуться на задание';
    }

    public function getUrl(): string
    {
        return Url::to(['task/bid', 'id' => $this->task->id]);
    }
}