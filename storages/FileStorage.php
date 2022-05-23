<?php

namespace app\storages;

use app\storages\exceptions\SaveException;
use JetBrains\PhpStorm\Pure;
use yii\web\UploadedFile;

class FileStorage
{

    public const PREFIX = '@webroot';

    public function save(UploadedFile $uploadedFile, string $path): bool
    {
        $file = $this->createPath($uploadedFile, $path);
        $result = $uploadedFile->saveAs($file);
        if (!$result) {
            throw new SaveException("Can't save file.");
        }

        return true;
    }

    #[Pure] private function createPath(UploadedFile $uploadedFile, string $path): string
    {
        return self::PREFIX . '/' . $path . '/' . $uploadedFile->getBaseName() . '.' . $uploadedFile->extension;
    }
}