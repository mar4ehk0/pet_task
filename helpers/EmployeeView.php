<?php

namespace app\helpers;

use app\models\City;
use app\models\Employee;
use app\models\User;
use app\repositories\CityRepository;
use app\repositories\EmployeeRepository;
use app\repositories\UserRepository;

class EmployeeView
{
    private Employee $employee;
    private User $user;
    private City $city;

    public function __construct(
        int $user_id,
        EmployeeRepository $employeeRepository,
        UserRepository $userRepository,
        CityRepository $cityRepository
    ) {
        $this->employee = $employeeRepository->findByUserId($user_id);
        $this->user = $userRepository->find($this->employee->user_id);
        $this->city = $cityRepository->find($this->user->city_id);
    }

    public function isHiddenContact(): bool
    {
        return $this->employee->hide_contacts;
    }

    public function getRatingValue(): float
    {
        return $this->employee->rating;
    }

    public function getDataRegistered(): string
    {
        return (new \DateTime($this->user->created))->format('d m Y, H:i');
    }

    public function getCity(): string
    {
        return $this->city->name;
    }

    public function getAbout(): string
    {
        return $this->employee->about;
    }

    public function getPhone(): string
    {
        return $this->employee->phone;
    }

    public function getTelegram(): string
    {
        return $this->employee->telegram;
    }
}
