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
        'action' => Url::to(['task/clients']),
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


