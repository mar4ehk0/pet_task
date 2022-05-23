<?php

namespace app\helpers;

use app\models\File;
use JetBrains\PhpStorm\Pure;
use yii\helpers\Url;

class FileView
{

    public const PREFIX = '@web';

    private File $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function getUrl(): string
    {
        return Url::to($this->createPath());
    }
    
    public function getName(): string
    {
        return $this->file->name;
    }

    #[Pure] public function getSize(): string
    {
        return $this->formatBytes($this->file->size);
    }

    final protected function formatBytes($bytes, $precision = 2): string
    {
        if( ($bytes >= 1<<30)) {
            return number_format($bytes / (1 << 30), 2) . "GB";
        }
        if( ($bytes >= 1<<20)) {
            return number_format($bytes / (1 << 20), 2) . "MB";
        }
        if( ($bytes >= 1<<10)) {
            return number_format($bytes / (1 << 10), 2) . "KB";
        }
        return number_format($bytes)."B";
    }

    private function createPath(): string
    {
        return self::PREFIX . '/' . $this->file->path . '/' . $this->file->name;
    }
}