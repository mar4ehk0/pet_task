<?php

namespace app\helpers;

use yii\base\Model;

class ViewHelper
{
    public static function isValidAttribute(string $attribute, Model $model): bool
    {
        $errors = $model->getErrors();
        if (isset($errors[$attribute])) {
            return false;
        }
        return true;
    }
}