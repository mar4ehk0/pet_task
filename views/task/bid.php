<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\forms\CreateBidForm $model */

use app\helpers\ViewHelper;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\assets\CreateTaskAsset;

CreateTaskAsset::register($this);

$this->title = 'Ваша предложение';
$this->params['breadcrumbs'][] = $this->title;

$statusPrice = ViewHelper::isValidAttribute('price', $model)  ? '' : 'is-invalid';

?>
<div class="task-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'task-offer-bid-form',
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

    <?= $form->field($model, 'description')->textarea() ?>
    <?= $form->field($model, 'price')->textInput(
        [ 'options' => ['class' => 'col-5 form-control ' . $statusPrice],]
    ) ?>

    <div class="form-group">
        <div class="offset-5 col-5">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'offer-bid-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>


