<?php

namespace app\repositories;

use app\models\File;
use app\repositories\exceptions\NotFoundException;
use app\storages\FileStorage;

class FileRepository
{
    public function find(int $id): File
    {
        if (!$file = File::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $file;
    }

    public function add(File $file): bool
    {
        if (!$file->getIsNewRecord()) {
            throw new \RuntimeException('Adding existing model.');
        }
        if (!$file->insert(false)) {
            throw new \RuntimeException('Saving error.');
        }

        return true;
    }

    public function save(File $file): bool
    {
        if ($file->getIsNewRecord()) {
            throw new \RuntimeException('Saving new model.');
        }
        if ($file->update(false) === false) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }

    public function delete(File $file): bool
    {
        if (!$file->delete()) {
            throw new \RuntimeException('Deleting error.');
        }

        return true;
    }
}
