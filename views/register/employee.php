<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\forms\EmployeeRegisterForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\jui\DatePicker;

$this->title = 'Регистрация Исполнителя';
$this->params['breadcrumbs'][] = $this->title;

$statusBirthday = $model->isAgeValid() ? '' : 'is-invalid';

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

    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>
    <?= $form->field($model, 'birthday')
        ->widget(
            DatePicker::class,
            [
                'options' => ['class' => 'col-5 form-control ' . $statusBirthday],
                'dateFormat' => 'yyyy-MM-dd'
            ]
        )
    ?>
    <?= $form->field($model, 'city_id')->dropDownList($model->getCityList()) ?>
    <?= $form->field($model, 'about')->textarea() ?>
    <?= $form->field($model, 'phone')->textInput() ?>
    <?= $form->field($model, 'telegram')->textInput() ?>

    <div class="form-group">
        <div class="offset-5 col-5">
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
