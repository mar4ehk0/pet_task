<?php

namespace app\services\dto;

class EmployeeDTO
{
    public UserDTO $userDTO;
    public string $about;
    public ContactDTO $contactDTO;

    public function __construct(UserDTO $userDTO, string $about, ContactDTO $contactDTO)
    {
        $this->userDTO = $userDTO;
        $this->about = $about;
        $this->contactDTO = $contactDTO;
    }
}