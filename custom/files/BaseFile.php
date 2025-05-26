<?php

declare(strict_types=1);

namespace app\custom\files;

use app\custom\helpers\StorageFileHelper;

class BaseFile
{
    protected $bucket;

    public function __construct($bucket)
    {
        $this->bucket = $bucket;
    }

    public function save()
    {
        return StorageFileHelper::saveAsIs($this->getBucket());
    }

    public function getBucket()
    {
        return $this->bucket;
    }

    public function getPath($fileName)
    {
        return StorageFileHelper::getPath($fileName, $this->getBucket());
    }
}
