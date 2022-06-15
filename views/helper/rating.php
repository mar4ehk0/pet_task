<?php

/** @var yii\web\View $this */
/** @var int $rating */

use yii\bootstrap4\Html;

?>

<div class="progress">
    <div class="progress-bar" role="progressbar" style="width: <?=Html::encode($rating)?>%" aria-valuenow="<?=Html::encode($rating)?>" aria-valuemin="0" aria-valuemax="100"></div>
</div>
