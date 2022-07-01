<?php
namespace app\dtos;

class PeriodDTO
{



    public string $from;
    public string $to;

    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
}
