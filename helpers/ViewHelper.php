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

    public static function getRelativeTime(\DateTime $dateTime): string
    {
        $current = new \DateTime();
        $interval = $current->diff($dateTime);
        // @TODO plural для вывода дат
        if (!empty($interval->y)) {
            return $interval->y . 'лет назад';
        }

        if (!empty($interval->m)) {
            return $interval->m . 'месяц назад';
        }

        if (!empty($interval->d)) {
            return $interval->d . 'дней назад';
        }

        if (!empty($interval->h)) {
            return $interval->h . 'часов назад';
        }

        if (!empty($interval->i)) {
            return $interval->i . 'минут назад';
        }

        return 'недавно';
    }

    public static function getPrice(?int $price): string
    {
        if ($price === null) {
            return 'Цена не определена';
        }

        return $price . '₽';
    }

    public static function convertRating(float $rating): int
    {
        $rating *= 10;
        return floor(($rating * 100) / 50);
    }
}
