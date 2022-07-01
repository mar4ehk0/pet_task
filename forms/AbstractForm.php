<?php

namespace app\forms;

use yii\base\Model;

abstract class AbstractForm extends Model
{
    public function guardIsActualDate($attribute, $params, $validator): bool
    {
        if (empty($this->{$attribute})) {
            $this->addError($attribute, 'Срок завершения не может быть пустым.');
            return false;
        }

        $currentDate = new \DateTime();
        $deadline = new \DateTime($this->{$attribute});
        if ($currentDate > $deadline) {
            $this->addError($attribute, 'Срок завершения не может быть меньше текущей даты.');
            return false;
        }
        return true;
    }

    public function guardIsValidPrice($attribute, $params, $validator): bool
    {
        if (!isset($this->{$attribute})) {
            return false;
        }

        if (!empty($this->{$attribute})) {
            if (!is_numeric($this->{$attribute}) || !is_int((int)$this->{$attribute})) {
                $this->addError($attribute, 'Поле может быть целым число.');
                return false;
            }
            if ($this->{$attribute} < 0) {
                $this->addError($attribute, 'Поле не может быть отрицательным.');
                return false;
            }
        }
        return true;
    }

    public function guardIsUserMature($attribute, $params, $validator)
    {
        if (!isset($this->{$attribute})) {
            return false;
        }

        $limitDate = new \DateTime();
        $limitDate->sub(new \DateInterval('P18Y'));
        $birthday = new \DateTime($this->{$attribute});
        if ($birthday > $limitDate) {
            $this->addError($attribute, 'У нас работают только совершеннолетние.');
            return false;
        }

        return true;
    }
}
