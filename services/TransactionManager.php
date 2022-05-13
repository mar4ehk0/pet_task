<?php

namespace app\services;

class TransactionManager
{
    public function execute(callable $function): void
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            call_user_func($function);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
} 