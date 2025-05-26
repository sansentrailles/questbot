<?php

declare(strict_types=1);

namespace app\custom\helpers;

use Yii;

/**
 * A set of methods used for working with file uploading.
 *
 *  @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */
class UploadFileHelper
{
    public static function generateTempFile()
    {
        $tempDir = Yii::getAlias('@runtime') . '/tempUploadedFiles';
        $level = 3;

        return static function ($model, $uploadedFile, $file, $oldFile) use ($tempDir, $level) {
            $file = FileHelper::generateUniqueFile($uploadedFile, $level, $tempDir);
            FileHelper::createDirectory(\dirname($file));

            if (is_dir($uploadedFile->tempName) || $uploadedFile->tempName === '') {
                return null;
            }

            // Yii::debug($uploadedFile->tempName);
            // echo __METHOD__.' '.$uploadedFile->tempName.PHP_EOL;
            $sourceFileData = file_get_contents($uploadedFile->tempName);
            file_put_contents($file, $sourceFileData);
            // $uploadedFile->saveAs($file, false);
            return [$file, static function () use ($file): void {
                FileHelper::deleteFile($file);
            }];
        };
    }

    public static function getFilePath($bucketName, $fileName)
    {
        $bucket = Yii::$app->fileStorage->getBucket($bucketName);
        return $bucket->getFileUrl($fileName);
    }
}
