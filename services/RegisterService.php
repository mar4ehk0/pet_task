<?php

namespace app\services;

use app\forms\EmployeeRegisterForm;
use app\models\Client;
use app\models\Employee;
use app\models\User;
use app\rbac\RBACManager;
use app\repositories\CategoryRepository;
use app\repositories\ClientRepository;
use app\repositories\EmployeeRepository;
use app\repositories\UserRepository;
use app\services\dto\ClientDTO;
use app\services\dto\ContactDTO;
use app\services\dto\EmployeeDTO;
use app\services\dto\UserDTO;

class RegisterService
{
    private EmployeeRepository $employeeRepository;
    private ClientRepository $clientRepository;
    private UserRepository $userRepository;
    private TransactionManager $transactionManager;
    private RBACManager $RBACManager;
    private CategoryRepository $categoryRepository;

    public function __construct(
        EmployeeRepository $employeeRepository,
        ClientRepository $clientRepository,
        UserRepository $userRepository,
        CategoryRepository $categoryRepository,
        TransactionManager $transactionManager,
        RBACManager $RBACManager
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->clientRepository = $clientRepository;
        $this->userRepository = $userRepository;
        $this->transactionManager = $transactionManager;
        $this->RBACManager = $RBACManager;
        $this->categoryRepository = $categoryRepository;
    }

//    public function createEmployee(EmployeeDTO $employeeDTO)
//    {
//        $user = User::create($employeeDTO->userDTO);
//        $employee = Employee::create($user, $employeeDTO->about, $employeeDTO->contactDTO, $employeeDTO->categories_id);
//        $this->transactionManager->execute(function () use ($user, $employee) {
//            $this->userRepository->add($user);
//            $this->employeeRepository->add($employee);
//            $this->RBACManager->assignEmployee($employee);
//        });
//        // @TODO добавить eventdispetcher и там уже отправка письма
//        return $employee;
//    }

    public function createEmployee(EmployeeRegisterForm $model): Employee
    {
        $user = User::create(
            new UserDTO($model->name, $model->email, $model->password, $model->birthday, $model->city_id)
        );
        $contact = new ContactDTO($model->phone, $model->telegram);
        $categories = $this->categoryRepository->findMultiple($model->categories_id);
        $employee = Employee::create($user, $model->about, $contact, $categories);
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
