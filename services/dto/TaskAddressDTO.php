<?php

namespace app\services\dto;

class TaskAddressDTO
{
    public string $location;
    public string $address;
    public ?int $city_id;
    public string $lat;
    public string $long;

    public function __construct(
        string $location,
        string $address,
        string $city_id,
        string $lat,
        string $long,
    ) {
        $this->location = $location;
        $this->address = $address;
        $this->city_id = empty($city_id) ? null : $city_id;
        $this->lat = $lat;
        $this->long = $long;
    }
}
