<?php

namespace app\services;

use app\forms\CreateTaskForm;
use app\models\Task;
use app\repositories\TaskRepository;
use app\services\dto\TaskAddressDTO;
use app\services\dto\TaskRequiredPropertiesDTO;

class TaskService
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function create(CreateTaskForm $createTaskForm)
    {
//        $user = User::create($employeeDTO->userDTO);
//        $employee = Employee::create($user, $employeeDTO->about, $employeeDTO->contactDTO);
//        $this->transactionManager->execute(function () use ($user, $employee) {
//            $this->userRepository->add($user);
//            $this->employeeRepository->add($employee);
//        });

        $task = $this->createTask($createTaskForm);
        $this->taskRepository->add($task);
    }

    private function createTask(CreateTaskForm $createTaskForm): Task
    {
        $taskRequiredPropertiesDTO = new TaskRequiredPropertiesDTO(
            $createTaskForm->title,
            $createTaskForm->description,
            $createTaskForm->category_id,
            $createTaskForm->price,
            $createTaskForm->deadline,
            $createTaskForm->client_id,
            $createTaskForm->is_remote
        );

        if ($createTaskForm->is_remote) {
            $task = Task::createRemote($taskRequiredPropertiesDTO);
        } else {
            $taskAddressDTO = new TaskAddressDTO(
                $createTaskForm->location,
                $createTaskForm->address,
                $createTaskForm->city_id,
                $createTaskForm->lat,
                $createTaskForm->long,
            );
            $task = Task::createDirect($taskRequiredPropertiesDTO, $taskAddressDTO);
        }

        return $task;
    }

}