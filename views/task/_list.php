<?php

/** @var yii\web\View $this */
/** @var app\dtos\TaskListViewDTO $model */

use app\helpers\TaskView;
use yii\bootstrap4\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

?>

<div class="task-list">
    <?php if (empty($model->tasks)) :?>
        <h1>Ничего не найдено!</h1>
    <?php else : ?>
        <?php /** @var TaskView $task */ ?>
        <?php foreach ($model->tasks as $task) : ?>
            <div class="card">
                <div class="card-body">
                    <div class="publish-date text-right"><?= Html::encode($task->getPublicationDate()) ?></div>
                    <a href="<?=Url::to(['task/view', 'id' => $task->getId()])?>">
                        <h2 class="card-title"><?= Html::encode($task->getTitle()) ?></h2>
                     </a>
                    <div class="card-text">
                        <?= Html::encode($task->getDescription()) ?>
                    </div>
                    <div class="row">
                        <div class="col-6 text-left">
                            <?= Html::encode($task->getLocation()) ?>
                        </div>
                        <div class="col-6 text-right">
                            <?= Html::encode($task->getCategory()) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    <?php endif;?>
</div>
<div class="pagination">
    <?= LinkPager::widget(['pagination' => $model->pages])?>
</div>
