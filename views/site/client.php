<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\forms\LoginForm $model */

use kartik\icons\Icon;
use yii\helpers\Url;

$this->title = 'Ваши задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-home container">
    <div class="create-task row justify-content-end">
        <div class="col-3">
            <a href="<?= Url::to(['task/create']);?>" class="btn btn-outline-primary ">
                Создать Задачу <?php echo Icon::show('pen'); ?>
            </a>
        </div>
    </div>
    <div class="client-tasks"></div>
</div>