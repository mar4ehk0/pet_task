<?php

namespace app\services\dto;

use app\models\Bid;

class BidResultDTO
{
    public Bid $bid;
    public bool $result;

    public function __construct(Bid $bid, bool $result)
    {
        $this->bid = $bid;
        $this->result = $result;
    }

}