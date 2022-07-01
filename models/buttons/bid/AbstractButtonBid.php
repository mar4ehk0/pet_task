<?php

namespace app\models\buttons\bid;

use app\models\Bid;
use app\models\buttons\AbstractButton;

abstract class AbstractButtonBid extends AbstractButton
{
    protected Bid $bid;

    public function __construct(Bid $bid, $config = [])
    {
        parent::__construct($config);
        $this->bid = $bid;
    }
}
