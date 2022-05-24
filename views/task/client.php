<?php

/** @var yii\web\View $this */
/** @var app\forms\FindTaskForm $model */

use kartik\icons\Icon;
use yii\helpers\Url;

$this->title = 'Ваши задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-home container">
    <div class="create-task row justify-content-end">
        <div class="col-3">
            <a href="<?= Url::to(['task/create']) ?>" class="btn btn-outline-primary ">
                Создать Задачу <?php echo Icon::show('pen'); ?>
            </a>
        </div>
    </div>
    <br/>
    <div class="client-tasks row">
        <div class="col-8 tasks">

        </div>
        <div class="col-4 form">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>