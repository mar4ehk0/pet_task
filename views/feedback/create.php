<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\forms\FeedbackForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Оставить отзыв исполнителю';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="feedback-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="list-group">
        <li class="list-group-item">Задача: <?= Html::encode($model->taskView->getTitle()) ?></li>
        <li class="list-group-item">Исполнитель: <?= Html::encode($model->employee->user->name) ?></li>
    </ul>

    <div class="container pt-md-5">
        <?php $form = ActiveForm::begin([
            'id' => 'feedback-create-form',
            'enableClientValidation' => true,
            'validateOnSubmit' => true,
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-3 col-form-label'],
                'inputOptions' => ['class' => 'col-5 form-control'],
                'errorOptions' => ['class' => 'col-4 invalid-feedback'],
            ],
        ]); ?>

        <?= $form->field($model, 'body')->textarea(['autofocus' => true]) ?>
        <?= $form->field($model, 'grade')->textInput() ?>

        <div class="form-group">
            <div class="offset-5 col-5">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'save']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>


