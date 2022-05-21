<?php

namespace app\helpers;

use app\models\File;
use yii\helpers\Url;

class FileView
{
    private File $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function getUrl(): string
    {
        return Url::to($this->file->path . '/' . $this->file->name, true);
    }
    
    public function getName(): string
    {
        return $this->file->name;
    }

    public function getSize(): string
    {
        return $this->formatBytes($this->file);
    }

    final protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}