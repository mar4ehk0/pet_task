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
                <div class="description bg-light">
                    <?= Html::encode($model->getDescription()) ?>
                </div>
                <br/>
                <?php if ($model->getButton()) :?>
                    <div class="button">
                        <a href="<?=Html::encode($model->getButtonUrl())?>" class="btn btn-primary">
                            <?=Html::encode($model->getButtonTitle())?>
                        </a>
                    </div>
                    <br/>
                <?php endif; ?>
                <div class="location">
                    <?= Html::encode($model->getLocation()) ?>
                </div>
                <br/>
                <?php if ($listBidView = $model->getListBidView()) :?>
                    <div class="bids">
                        <h4> Отклики на задание </h4>
                        <?php foreach ($listBidView as $bidView) :?>
                            <div class="card bid bg-light">
                                <?php if ($bidView->isAccepted()) :?>
                                    <span class="badge badge-info">Выбран</span>
                                <?php endif; ?>
                                <?php if ($bidView->isDeclined()) :?>
                                    <span class="badge badge-danger">Отклонен</span>
                                <?php endif; ?>
                                <div class="card-body row">
                                    <div class="col-3">
                                        <div class="avatar">avatar</div>
                                    </div>
                                    <div class="col-9">
                                        <div class="rating"><?= $this->render('@app/views/helper/rating', [
                                                'rating' => $bidView->getEmployeeRating(),
                                            ]) ?></div>
                                        <div class="name"><?=Html::encode($bidView->getEmployeeName())?></div>
                                        <div class="description"><?=Html::encode($bidView->getDescription())?></div>
                                        <div class="price"><?=Html::encode($bidView->getPrice())?></div>
                                        <div class="number-feedback"><?=Html::encode($bidView->getNumFeedback())?></div>
                                        <div class="publish-date"><?=Html::encode($bidView->getPublicationDate())?></div>
                                    </div>
                                    <?php if ($bidView->getButtons()) : ?>
                                        <div class="btn-group row">
                                            <?php foreach ($bidView->getButtons() as $button) : ?>
                                                <div class="col-6">
                                                    <a href="<?=Html::encode($button->getUrl())?>" class="btn btn-primary">
                                                    <?=Html::encode($button->getName())?>
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <br/>
                        <?php endforeach;?>
                    </div>
                <?php endif; ?>
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
                    <?php foreach ($model->getFiles() as $file) : ?>
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


