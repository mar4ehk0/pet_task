<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\forms\FindTaskForm $model */

use kartik\icons\Icon;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

?>
<div class="task-search">
    <?php $form = ActiveForm::begin([
        'id' => 'task-search-form',
        'method' => 'get',
        'enableClientValidation' => true,
        'validateOnSubmit' => true,
        'options' => [
            'name' => 'test',
        ],
        'action' => Url::to(['task/clients']),
//        'layout' => 'horizontal',
//        'fieldConfig' => [
//            'template' => "{label}\n{input}\n{error}",
//            'labelOptions' => ['class' => 'col-3 col-form-label'],
//            'inputOptions' => ['class' => 'col-5 form-control'],
//            'errorOptions' => ['class' => 'col-4 invalid-feedback'],
//        ],
    ]); ?>
    <div class="categories">
        <h4>Категории</h4>
        <?= $form->field($model, 'categories', ['template' => "{input}"])->checkboxList($model->getCategoryList()) ?>
        <br/>
    </div>

    <div class="status">
        <?= $form->field($model, 'status')->dropdownList($model->getListStatus()) ?>
        <br/>
    </div>
    <div class="period">
        <?= $form->field($model, 'period')->dropdownList($model->getPeriodList()) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Искать ' . Icon::show('search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


