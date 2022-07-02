<?php

namespace app\services;

use app\forms\FeedbackForm;
use app\models\Feedback;
use app\repositories\FeedbackRepository;

class FeedbackService
{
    private FeedbackRepository $feedbackRepository;
    private TransactionManager $transactionManager;
    private TaskService $taskService;

    public function __construct(
        FeedbackRepository $feedbackRepository,
        TaskService $taskService,
        TransactionManager $transactionManager
    ) {
        $this->feedbackRepository = $feedbackRepository;
        $this->transactionManager = $transactionManager;
        $this->taskService = $taskService;
    }

    public function createFeedback(FeedbackForm $feedbackForm): bool
    {
        $feedback = Feedback::create($feedbackForm->body, $feedbackForm->grade, $feedbackForm->task->id);
        $func = $this->taskService->completeTask($feedback);

        $this->transactionManager->execute(function () use ($feedback, $func) {
            $this->feedbackRepository->add($feedback);
            $func();
        });

        return true;
    }
}
