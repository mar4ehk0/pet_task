<?php

namespace app\services\dto;

class ClientDTO
{
    public UserDTO $userDTO;

    public function __construct(UserDTO $userDTO)
    {
        $this->userDTO = $userDTO;
    }
}