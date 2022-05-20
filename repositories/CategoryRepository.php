<?php

namespace app\repositories;

use app\models\Category;
use app\repositories\exceptions\NotFoundException;

class CategoryRepository
{
    public function find(int $id): Category
    {
        if (!$category = Category::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $category;
    }

    public function findAll(): array
    {
        if (!$categories = Category::find()->all()) {
            throw new NotFoundException('There are no rows.');
        }

        return $categories;
    }
}