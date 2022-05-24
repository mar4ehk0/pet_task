<?php

namespace app\helpers;

use app\models\Task;
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

    public static function getListStatusTask(): array
    {
        return [
            Task::STATUS_NEW => 'Ищет исполнителя',
            Task::STATUS_CANCELED => 'Отменено заказчиком',
            Task::STATUS_IN_WORK => 'В работе',
            Task::STATUS_COMPLETED => 'Выполнено',
            Task::STATUS_FAILED => 'Исполнитель отказался',
        ];

    }
}