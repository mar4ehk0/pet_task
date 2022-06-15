<?php

/** @var yii\web\View $this */
/** @var app\helpers\SearchTaskView $model */

use app\helpers\TaskView;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-home container">
    <div class="client-tasks row">
        <div class="col-8 tasks">
            <?= $this->render('_list', [
                'model' => $model->getData(),
            ]) ?>
        </div>
        <div class="col-4 form">
            <?= $this->render('_form', [
                'model' => $model->getForm(),
            ]) ?>
        </div>
    </div>
</div>