<?php

namespace app\services;

use app\forms\FeedbackForm;
use app\models\Feedback;
use app\repositories\FeedbackRepository;
use app\repositories\TaskRepository;

class FeedbackService
{
    private FeedbackRepository $feedbackRepository;
    private TransactionManager $transactionManager;
    private TaskRepository $taskRepository;

    public function __construct(
        FeedbackRepository $feedbackRepository,
        TaskRepository $taskRepository,
        TransactionManager $transactionManager
    ) {
        $this->feedbackRepository = $feedbackRepository;
        $this->transactionManager = $transactionManager;
        $this->taskRepository = $taskRepository;
    }

    public function createFeedback(FeedbackForm $feedbackForm): bool
    {
        $feedback = Feedback::create($feedbackForm->body, $feedbackForm->grade, $feedbackForm->task->id);
        // @TODO по событию передать чтобы задача завершилась если был создан успешно feedback
        $task = $feedbackForm->task;
        $task->complete();

        $this->transactionManager->execute(function () use ($feedback, $task) {
            $this->feedbackRepository->add($feedback);
            $this->taskRepository->save($task);
        });

        return true;
    }
}