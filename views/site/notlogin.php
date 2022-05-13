<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

use yii\helpers\Url;
use kartik\icons\Icon;

?>

<div class="home">
    <div id="block">
        <div class="jumbotron text-center bg-transparent">
            <h1 class="display-4">TaskForce!</h1>
            <p class="lead">Лучшие профессоналы работают с нами.</p>
        </div>
        <div class="row">
            <div class="col text-center">
                <h2>Зарегистрироваться как ...</h2>
            </div>
        </div>
        <br>
        <br>
        <div class="row justify-content-around text-center align-items-center">
            <div class="col-3">
                <a href="<?= Url::to(['register/employee']);?>" class="btn btn-outline-primary">Исполнитель <?php echo Icon::show('wrench'); ?></a>
            </div>
            <div class="col-3">
                <a href="<?= Url::to(['register/client']);?>" class="btn btn-outline-success">Заказчик <?php echo Icon::show('wallet'); ?></a>
            </div>
        </div>
    </div>

    <br>
    <br>

    <div id="last_task" class="card">
        <div class="card-body">
            <div class="row">
                <div class="col text-center text-primary">
                    <h2>Актуальные задачи</h2>
                </div>
            </div>
            <div class="row text-center align-items-center">
                <div class="col">
                    <h3>Замена электрики</h3>
                </div>
                <div class="col">
                    <h3>Перевод</h3>
                </div>
                <div class="col">
                    <h3>Переезд</h3>
                </div>
                <div class="col">
                    <h3>Убрать квартиру</h3>
                </div>
                <div class="col">
                    <h3>Выгул собак</h3>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor..</div>
                </div>
                <div class="col">
                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor..</div>
                </div>
                <div class="col">
                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor..</div>
                </div>
                <div class="col">
                    <div>Lorem ipsum dolor sit amet, consectetur  sit amet, consectetur  sit amet, consectetur  sit amet, consectetur  sit amet, consectetur adipiscing elit, sed do eiusmod tempor..</div>
                </div>
                <div class="col">
                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor..</div>
                </div>
            </div>
            <div class="row text-center align-items-center">
                <div class="col">
                    <h1><?php echo Icon::show('hammer'); ?></h1>
                </div>
                <div class="col">
                    <h1><?php echo Icon::show('book'); ?></h1>
                </div>
                <div class="col">
                    <h1><?php echo Icon::show('truck'); ?></h1>
                </div>
                <div class="col">
                    <h1><?php echo Icon::show('broom'); ?></h1>
                </div>
                <div class="col">
                    <h1><?php echo Icon::show('paw'); ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>
