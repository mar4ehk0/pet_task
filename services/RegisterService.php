<?php

namespace app\services;

use app\models\Client;
use app\models\Employee;
use app\models\User;
use app\rbac\RBACManager;
use app\repositories\ClientRepository;
use app\repositories\EmployeeRepository;
use app\repositories\UserRepository;
use app\services\dto\ClientDTO;
use app\services\dto\EmployeeDTO;

class RegisterService
{
    private EmployeeRepository $employeeRepository;
    private ClientRepository $clientRepository;
    private UserRepository $userRepository;
    private TransactionManager $transactionManager;
    private RBACManager $RBACManager;

    public function __construct(
        EmployeeRepository $employeeRepository,
        ClientRepository $clientRepository,
        UserRepository $userRepository,
        TransactionManager $transactionManager,
        RBACManager $RBACManager
    )
    {
        $this->employeeRepository = $employeeRepository;
        $this->clientRepository = $clientRepository;
        $this->userRepository = $userRepository;
        $this->transactionManager = $transactionManager;
        $this->RBACManager = $RBACManager;
    }

    public function createEmployee(EmployeeDTO $employeeDTO)
    {
        $user = User::create($employeeDTO->userDTO);
        $employee = Employee::create($user, $employeeDTO->about, $employeeDTO->contactDTO);
        $this->transactionManager->execute(function () use ($user, $employee) {
            $this->userRepository->add($user);
            $this->employeeRepository->add($employee);
            $this->RBACManager->assignEmployee($employee);
        });
        // @TODO добавить eventdispetcher и там уже отправка письма
        return $employee;
    }

    public function createClient(ClientDTO $clientDTO)
    {
        $user = User::create($clientDTO->userDTO);
        $client = Client::create($user);
        $this->transactionManager->execute(function () use ($user, $client) {
            $this->userRepository->add($user);
            $this->clientRepository->add($client);
            $this->RBACManager->assignClient($client);
        });
        // @TODO добавить eventdispetcher и там уже отправка письма
        return $client;
    }
}