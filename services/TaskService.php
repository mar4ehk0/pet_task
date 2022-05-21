<?php

namespace app\services;

use app\forms\CreateTaskForm;
use app\helpers\TaskView;
use app\models\File;
use app\models\Task;
use app\repositories\FileRepository;
use app\repositories\TaskRepository;
use app\services\dto\FilesDTO;
use app\services\dto\TaskAddressDTO;
use app\services\dto\TaskRequiredPropertiesDTO;
use app\storages\FileStorage;
use yii\web\UploadedFile;

class TaskService
{
    private TaskRepository $taskRepository;
    private FileRepository $fileRepository;
    private TransactionManager $transactionManager;
    private FileStorage $fileStorage;

    public function __construct(
        TaskRepository $taskRepository,
        FileRepository $fileRepository,
        FileStorage $fileStorage,
        TransactionManager $transactionManager,
    )
    {
        $this->taskRepository = $taskRepository;
        $this->fileRepository = $fileRepository;
        $this->fileStorage = $fileStorage;
        $this->transactionManager = $transactionManager;
    }

    public function create(CreateTaskForm $createTaskForm)
    {
        $task = $this->createTask($createTaskForm);
        $filesDTO = $this->createFiles($createTaskForm, $task);

        $this->transactionManager->execute(function () use ($task, $filesDTO) {
            $this->taskRepository->add($task);
            foreach ($filesDTO as $fileDTO) {
                $this->fileStorage->save($fileDTO->uploadedFile, $fileDTO->file->path);
                $this->fileRepository->add($fileDTO->file);
            }
        });
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

    /**
     * @return FilesDTO[]
     */
    private function createFiles(CreateTaskForm $createTaskForm, Task $task): array
    {
        $uploadedFiles = UploadedFile::getInstances($createTaskForm, 'files');

        $files = [];
        foreach ($uploadedFiles as $uploadedFile) {
            $file = File::create(
                $task,
                $uploadedFile->name,
                $uploadedFile->getExtension(),
                $createTaskForm->client_id,
                $uploadedFile->size,
            );
            $filesDTO = new FilesDTO($uploadedFile, $file);
            $files[] = $filesDTO;
        }

        return $files;
    }

    public function getTaskView($id): TaskView
    {
        $task = $this->taskRepository->find($id);
        return new TaskView($task);
    }




}