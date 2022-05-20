<?php

namespace app\storages;

use app\storages\exceptions\SaveException;
use yii\web\UploadedFile;

class FileStorage
{

    public function save(UploadedFile $uploadedFile, string $path): bool
    {
        $file = $path . '/' . $uploadedFile->getBaseName() . '.' . $uploadedFile->extension;
        $result = $uploadedFile->saveAs($file);
        if (!$result) {
            throw new SaveException("Can't save file.");
        }

        return true;
    }
}