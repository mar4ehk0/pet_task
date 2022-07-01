<?php

namespace app\models\buttons\bid;

use yii\helpers\Url;

class DeclineButton extends AbstractButtonBid
{
    public function getName(): string
    {
        return 'Отказать';
    }

    public function getUrl(): string
    {
        return  Url::to(['bid/decline', 'id' => $this->bid->id]);
    }
}
