<?php

declare(strict_types=1);

namespace app\custom\helpers;

use Yii;
use yii\imagine\Image;

class ImageHelper
{
    public const VERTICAL_TOP = 101;
    public const VERTICAL_BOTTOM  = 102;
    public const VERTICAL_CENTER  = 103;

    public const HORIZONTAL_LEFT = 201;
    public const HORIZONTAL_RIGHT = 202;
    public const HORIZONTAL_CENTER = 203;
    protected static $bucket = 'images';

    public static function thumbnail($width, $height)
    {
        return static function ($model, $uploadedFile, $fileStorage, $file, $oldFile) use ($width, $height) {
            $bucket = $fileStorage->getBucket(self::$bucket);
            $fileName = basename($file);

            Image::thumbnail($file, $width, $height)->save($file);
            $bucket->copyFileIn($file, $fileName);
            $bucket->deleteFile($oldFile);
            return $file;
        };
    }

    public static function watermark($bucket, $watermark, $vertical, $horizontal, $margin_x, $margin_y)
    {
        return static function ($model, $uploadedFile, $fileStorage, $file, $oldFile) use ($bucket, $watermark, $vertical, $horizontal, $margin_x, $margin_y) {
            $bucket = $fileStorage->getBucket(self::$bucket);
            $fileName = basename($file);

            $imgFile = Image::getImagine()->open($file);
            $imgWatermark = Image::getImagine()->open($watermark);

            $sizeFile = $imgFile->getSize();
            $sizeWatermark = $imgWatermark->getSize();

            if ($vertical === self::VERTICAL_TOP) {
                $y = $margin_y;
            } elseif ($vertical === self::VERTICAL_BOTTOM) {
                $y = $sizeFile->getHeight() - ($sizeWatermark->getHeight() + $margin_y);
            } elseif ($vertical === self::VERTICAL_CENTER) {
                $y = ceil($sizeFile->getHeight() / 2) - ceil($sizeWatermark->getHeight() / 2);
            }

            if ($horizontal === self::HORIZONTAL_LEFT) {
                $x = $margin_x;
            } elseif ($horizontal === self::HORIZONTAL_RIGHT) {
                $x = $sizeFile->getWidth() - ($sizeWatermark->getWidth() + $margin_x);
            } elseif ($horizontal === self::HORIZONTAL_CENTER) {
                $x = ceil($sizeFile->getWidth() / 2) - ceil($sizeWatermark->getWidth() / 2);
            }

            Image::watermark($file, $watermark, [$x, $y])->save($file);

            // $bucket->copyFileIn($file, $fileName);
            // $bucket->deleteFile($oldFile);

            return $file;
        };
    }

    // public static function saveAsIs()
    // {
    //     return function ($model, $uploadedFile, $fileStorage, $file, $oldFile) {
    //         $bucket = $fileStorage->getBucket(self::$bucket);
    //         $fileName = basename($file);
    //         $bucket->copyFileIn($file, $fileName);
    //         $bucket->deleteFile($oldFile);
    //         return $fileName;
    //     };
    // }

    public static function getPath($fileName)
    {
        $bucket = Yii::$app->fileStorage->getBucket(self::$bucket);
        return $bucket->getFileUrl($fileName);
    }
}
