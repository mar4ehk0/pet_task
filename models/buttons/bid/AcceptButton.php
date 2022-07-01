<?php

namespace app\models\buttons\bid;

use yii\helpers\Url;

class AcceptButton extends AbstractButtonBid
{
    public function getName(): string
    {
        return 'Принять';
    }

    public function getUrl(): string
    {
        return  Url::to(['bid/accept', 'id' => $this->bid->id]);
    }
}
