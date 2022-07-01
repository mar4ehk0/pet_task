<?php

namespace app\repositories;

use app\models\City;
use app\repositories\exceptions\NotFoundException;

class CityRepository
{
    public function find(int $id): City
    {
        if (!$city = City::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $city;
    }

    public function findAll(): array
    {
        // TODO Add cache
        if (!$cities = City::find()->all()) {
            throw new NotFoundException('There are no rows.');
        }
        return $cities;
    }
}
