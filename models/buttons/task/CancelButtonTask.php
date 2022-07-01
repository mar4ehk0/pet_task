<?php

namespace app\models\buttons\task;

use yii\helpers\Url;

class CancelButtonTask extends AbstractButtonTask
{
    public function getName(): string
    {
        return 'Отменить';
    }

    public function getUrl(): string
    {
        return Url::to(['task/cancel', 'id' => $this->task->id]);
    }
}
