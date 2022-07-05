<?php

namespace app\services\dto;

class EmployeeDTO
{
    public UserDTO $userDTO;
    public string $about;
    public ContactDTO $contactDTO;
    public array $categories_id;

    public function __construct(UserDTO $userDTO, string $about, ContactDTO $contactDTO, array $categories_id)
    {
        $this->userDTO = $userDTO;
        $this->about = $about;
        $this->contactDTO = $contactDTO;
        $this->categories_id = $categories_id;
    }
}
