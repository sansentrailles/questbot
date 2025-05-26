<?php

declare(strict_types=1);

namespace app\modules\settings\files;

use app\custom\helpers\StorageFileHelper;

class SettingFile
{
    private static $bucket = 'settingFile';

    public function save()
    {
        return StorageFileHelper::saveAsIs(self::getBucket());
    }

    public static function getBucket()
    {
        return self::$bucket;
    }

    public static function getPath($fileName)
    {
        return StorageFileHelper::getPath($fileName, self::getBucket());
    }

    public static function getFullPath($fileName)
    {
        return StorageFileHelper::getFullPath($fileName, self::getBucket());
    }
}
