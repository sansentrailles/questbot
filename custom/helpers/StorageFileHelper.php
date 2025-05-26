<?php

declare(strict_types=1);

namespace app\custom\helpers;

use app\custom\files\Bucket;
use Yii;
use yii\imagine\Image;

class StorageFileHelper
{
    public const VERTICAL_TOP = 'top';
    public const VERTICAL_BOTTOM = 'bottom';
    public const VERTICAL_CENTER = 'center';
    public const HORIZONTAL_LEFT = 'left';
    public const HORIZONTAL_RIGHT = 'right';
    public const HORIZONTAL_CENTER = 'center';

    public static function removeFiles(array &$files): void
    {
        // $fileStorage = Yii::$app->fileStorage;
        foreach ($files as $item) {
            // $bucket = $fileStorage->getBucket($item['bucket']);
            $bucket = new Bucket($item['bucket']);
            $bucket->deleteFile($item['file']);
        }
    }

    public static function thumbnail($width, $height, $quality, $bucketName, $mode = null)
    {
        return static function ($model, $uploadedFile, $file, $oldFile) use ($width, $height, $quality, $bucketName, $mode) {
            // $bucket = $fileStorage->getBucket($bucketName);
            $bucket = new Bucket($bucketName);
            $fileName = basename($file);

            if ($mode) {
                Image::thumbnail($file, $width, $height, $mode)->save($file, ['quality' => $quality]);
            } else {
                Image::thumbnail($file, $width, $height)->save($file, ['quality' => $quality]);
            }

            return $file;
        };
    }

    public static function resize($options, $bucketName)
    {
        return static function ($model, $uploadedFile, $file, $oldFile) use ($options) {
            $newWidth = $newHeight = 0;

            [$width, $height] = getimagesize($file);

            if (isset($options['width']) || isset($options['height'])) {
                if (isset($options['width'], $options['height'])) {
                    $newWidth = $options['width'];
                    $newHeight = $options['height'];
                } elseif (isset($options['width'])) {
                    $deviationPercentage = (($width - $options['width']) / (0.01 * $width)) / 100;

                    $newWidth = $options['width'];
                    $newHeight = $height - ($height * $deviationPercentage);
                } else {
                    $deviationPercentage = (($height - $options['height']) / (0.01 * $height)) / 100;

                    $newWidth = $width - ($width * $deviationPercentage);
                    $newHeight = $options['height'];
                }
            } else {
                // reduce image size up to 20% by default
                $reduceRatio = $options['reduceRatio'] ?? 20;

                $newWidth = $width * ((100 - $reduceRatio) / 100);
                $newHeight = $height * ((100 - $reduceRatio) / 100);
            }

            Image::thumbnail(
                $file,
                (int)$newWidth,
                (int)$newHeight
            )->save(
                $file,
                ['quality' => $options['quality'] ?? 100]
            );

            return $file;
        };
    }

    public static function saveAsIsOld($bucketName)
    {
        return static function ($model, $uploadedFile, $file, $oldFile) use ($bucketName) {
            // $bucket = $fileStorage->getBucket($bucketName);
            $bucket = new Bucket($bucketName);

            $fileName = basename($file);
            // echo $fileName.'<br>';
            // echo $file.'<br>';
            // echo 'old ' . $oldFile . '<br>';
            // exit;
            $bucket->copyFileIn($file, $fileName);

            $bucket->deleteFile($oldFile);

            return $fileName;
        };
    }

    public static function saveAsIs($bucketName)
    {
        return static function ($model, $uploadedFile, $file, $oldFile) use ($bucketName) {
            $fileName = basename($file);
            $bucket = new Bucket($bucketName);
            $bucket->copyFileIn($file, $fileName);
            $bucket->deleteFile($oldFile);

            return $fileName;
        };
    }

    public static function getPath($fileName, $bucketName)
    {
        $bucket = new Bucket($bucketName);
        return $bucket->getFileUrl($fileName);
    }

    public static function setQuality($quality, $bucketName)
    {
        return static function ($model, $uploadedFile, $file, $oldFile) use ($quality) {
            $imgFile = Image::getImagine()->open($file);

            $imgFile->save($file, ['quality' => $quality]);

            return $file;
        };
    }

    public static function watermark($bucketName, $watermark, $position, $offset)
    {
        return static function ($model, $uploadedFile, $file, $oldFile) use ($watermarkFile, $position, $bucketName) {
            $bucket = $fileStorage->getBucket($bucketName);
            $fileName = basename($file);

            $watermark = Yii::getAlias('@webroot/' . $watermarkFile);
            // $size = getimagesize($file);
            // $imageWidth = $size[0];
            // $imageHeight = $size[1];
            // $watermarkPositionLeft = $imageWidth - $offset[0];
            // $watermarkPositionLeft = $imageWidth - $offset[0];

            $imgFile = Image::getImagine()->open($file);
            $imgWatermark = Image::getImagine()->open($watermark);

            $sizeFile = $imgFile->getSize();
            $sizeWatermark = $imgWatermark->getSize();

            [$horizontal, $vertical] = explode('-', $position);

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

            return $file;
        };
    }
}
