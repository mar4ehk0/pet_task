<?php

namespace app\services\dto;

use app\models\File;
use yii\web\UploadedFile;

class FilesDTO
{
    public UploadedFile $uploadedFile;
    public File $file;

    public function __construct(UploadedFile $uploadedFile, File $file)
    {
        $this->uploadedFile = $uploadedFile;
        $this->file = $file;
    }
}
