<?php

namespace app\services;

use app\forms\CreateTaskForm;
use app\forms\FindTaskForm;
use app\helpers\ListBidView;
use app\helpers\SearchTaskView;
use app\helpers\TaskPageView;
use app\models\Bid;
use app\models\File;
use app\models\Task;
use app\repositories\BidRepository;
use app\repositories\CategoryRepository;
use app\repositories\FileRepository;
use app\repositories\TaskRepository;
use app\repositories\UserRepository;
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
    private CategoryRepository $categoryRepository;
    private UserRepository $userRepository;
    private BidRepository $bidRepository;

    public function __construct(
        TaskRepository $taskRepository,
        FileRepository $fileRepository,
        CategoryRepository $categoryRepository,
        FileStorage $fileStorage,
        TransactionManager $transactionManager,
        UserRepository $userRepository,
        BidRepository $bidRepository
    )
    {
        $this->taskRepository = $taskRepository;
        $this->fileRepository = $fileRepository;
        $this->fileStorage = $fileStorage;
        $this->transactionManager = $transactionManager;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->bidRepository = $bidRepository;
    }

    public function create(CreateTaskForm $createTaskForm): Task
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

        return $task;
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

    public function getTaskPageView($task_id, $user_id): TaskPageView
    {
        $task = $this->taskRepository->find($task_id);
        $user = $this->userRepository->find($user_id);
        $bids = $this->bidRepository->findAllByTaskId($task_id);
        // @TODO тут будут Bids браться для данной задаче
        return new TaskPageView($task, $user, new ListBidView($bids));
    }

    public function getSearchTaskView(int $client_id, array $get): SearchTaskView
    {
        $model = new FindTaskForm($this->categoryRepository, $client_id, $get);
        $data = $this->taskRepository->findByQuery($model);

        return new SearchTaskView($model, $data);
    }

    public function startTask(Bid $bid): bool
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($bid->task_id);
        $task->status = Task::STATUS_IN_WORK;
        $task->employee_id = $bid->employee_id;

        $this->transactionManager->execute(function () use ($task) {
            $this->taskRepository->save($task);
        });

        return true;
    }

}