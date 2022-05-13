<?php

namespace app\services\dto;

class UserDTO
{
    public string $name;
    public string $email;
    public string $password;
    public string $birthday;
    public int $city_id;

    public function __construct(
        string $name,
        string $email,
        string $password,
        string $birthday,
        int    $city_id,
    )
    {
        $this->name = $name;
        $this->email = strtolower($email);
        $this->password = $password;
        $this->birthday = $birthday;
        $this->city_id = $city_id;
    }
}