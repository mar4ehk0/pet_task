<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\forms\CreateTaskForm $model */

use app\helpers\ViewHelper;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\jui\DatePicker;

$this->title = 'Создание Задачи';
$this->params['breadcrumbs'][] = $this->title;

$statusDeadline = ViewHelper::isValidAttribute('deadline', $model)  ? '' : 'is-invalid';

$this->registerJs(
    "
        $('#createtaskform-is_remote').on('change', function() { 
          if (this.checked) {
            $('.field-createtaskform-location').hide();
          } else {
            $('.field-createtaskform-location').show();
          } 
        });"
);

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'register-employee-form',
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

    <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'description')->textarea() ?>
    <?= $form->field($model, 'category_id')->dropDownList($model->getCategoryList()) ?>
    <?= $form->field($model, 'price')->textInput() ?>
    <?= $form->field($model, 'deadline')
        ->widget(
            DatePicker::class,
            [
                'options' => ['class' => 'col-5 form-control ' . $statusDeadline],
                'dateFormat' => 'yyyy-MM-dd'
            ]
        )
    ?>
    <?= $form->field($model, 'is_remote')->checkbox() ?>
    <?= $form->field($model, 'location')->textInput() ?>
    <?= $form->field($model, 'address')->hiddenInput()->label('') ?>
    <?= $form->field($model, 'city_id')->hiddenInput()->label('') ?>
    <?= $form->field($model, 'lat')->hiddenInput()->label('') ?>
    <?= $form->field($model, 'long')->hiddenInput()->label('') ?>

    <div class="form-group">
        <div class="offset-5 col-5">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>


