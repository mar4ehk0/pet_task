<?php

namespace app\services\dto;

class TaskRequiredPropertiesDTO
{
    public string $title;
    public string $description;
    public int $category_id;
    public ?int $price;
    public string $deadline;
    public int $client_id;
    public bool $is_remote;

    public function __construct(
        string $title,
        string $description,
        string $category_id,
        string $price,
        string $deadline,
        int $client_id,
        bool $is_remote
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->category_id = $category_id;
        $this->price = empty($price) ? null : $price ;
        $this->deadline = $deadline;
        $this->client_id = $client_id;
        $this->is_remote = $is_remote;
    }
}
