<?php

/** @var yii\web\View $this */
/** @var app\helpers\TaskPageView $model */

use app\helpers\FileView;
use yii\bootstrap4\Html;


$this->title = 'Просмотр задачи';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="task-view">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1><?= Html::encode($model->getTitle()) ?></h1>
            </div>
            <div class="col-sm-6">
                <h1><?= Html::encode($model->getPrice()) ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="description">
                    <?= Html::encode($model->getDescription()) ?>
                </div>
                <div class="buttons"> Buttons</div>
                <div class="location">
                    <?= Html::encode($model->getLocation()) ?>
                </div>
                <div class="bids"> Bids</div>
            </div>
            <div class="col-sm-4">
                <div class="task-about">
                    <h5 class="text-uppercase">Информация о задании</h5>
                    <div>
                        <span class="badge badge-primary">Категория</span>
                        <?= Html::encode($model->getCategory()) ?>
                    </div>
                    <div>
                        <span class="badge badge-primary">Дата публикации</span>
                        <?= Html::encode($model->getPublicationDate()) ?>
                    </div>
                    <div>
                        <span class="badge badge-primary">Срок выполнения</span>
                        <?= Html::encode($model->getDeadline()) ?>
                    </div>
                    <div>
                        <span class="badge badge-primary">Статус</span>
                        <?= Html::encode($model->getStatus()) ?>
                    </div>
                </div>
                <br/>
                <div class="task-files">
                    <h5 class="text-uppercase">Файлы задания</h5>
                    <?php /** @var FileView $file */ ?>
                    <?php foreach ($model->getFiles() as $file): ?>
                        <div class="task-file">
                            <div class="file-name">
                                <?= HTML::a($file->getName(), $file->getUrl()) ?>
                            </div>
                            <div class="file-size">
                                <?= HTML::encode($file->getSize()) ?>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>


