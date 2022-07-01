<?php

namespace app\models\buttons\task;

use app\models\Task;
use yii\helpers\Url;

class BidButtonTask extends AbstractButtonTask
{

    public function getName(): string
    {
        return 'Откликнуться на задание';
    }

    public function getUrl(): string
    {
        return Url::to(['bid/create', 'id' => $this->task->id]);
    }
}