<?php

namespace app\repositories;

use app\models\Employee;
use app\repositories\exceptions\NotFoundException;

class EmployeeRepository
{
    public function find(int $id): Employee
    {
        if (!$employee = Employee::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $employee;
    }

    public function add(Employee $employee): bool
    {
        if (!$employee->getIsNewRecord()) {
            throw new \RuntimeException('Adding existing model.');
        }
        if (!$employee->insert(false)) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }

    public function save(Employee $employee): bool
    {
        if ($employee->getIsNewRecord()) {
            throw new \RuntimeException('Saving new model.');
        }
        if ($employee->update(false) === false) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }

    public function delete(Employee $employee): bool
    {
        if (!$employee->delete()) {
            throw new \RuntimeException('Deleting error.');
        }

        return true;
    }
}