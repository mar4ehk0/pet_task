<?php

namespace app\models\buttons;

use yii\base\Model;

abstract class AbstractButton extends Model
{
    abstract public function getName(): string;
    abstract public function getUrl(): string;
}