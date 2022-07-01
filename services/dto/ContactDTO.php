<?php

namespace app\services\dto;

class ContactDTO
{
    public string $phone;
    public string $telegram;

    public function __construct(string $phone, string $telegram)
    {
        $this->phone = $phone;
        $this->telegram = $telegram;
    }
}
