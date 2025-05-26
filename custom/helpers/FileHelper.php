<?php

declare(strict_types=1);

namespace app\custom\helpers;

use yii\helpers\FileHelper as YiiFileHelper;
use yii\web\UploadedFile;

/**
 * A set of methods used for working with files.
 *
 *  @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */
class FileHelper extends YiiFileHelper
{
    /**
     * generates a unique file name with nested path
     * based on the file name itself.
     *
     * @param UploadFile file object
     * @param int level of nesting
     * @param string base path
     * @param mixed $level
     * @param mixed $base
     * @return string file pathname
     */
    public static function generateUniqueFile(UploadedFile $file, $level = 0, $base = '')
    {
        $key = random_int(100000, 999999) . md5(microtime() . $file->name);

        if ($level > 0) {
            for ($i = 0; $i < $level; ++$i) {
                if (($prefix = substr($key, $i + $i, 2)) !== false) {
                    $base .= \DIRECTORY_SEPARATOR . $prefix;
                }
            }
        }

        return $level === 0 ? "{$key}.{$file->extension}" : $base . \DIRECTORY_SEPARATOR . "{$key}.{$file->extension}";
    }

    /**
     * deletes the file.
     *
     * @param string absolute file path
     * @param mixed $file
     */
    public static function deleteFile($file): void
    {
        if (file_exists($file)) {
            unlink($file);
        }
    }

    public static function makePath(array $parts): string
    {
        return implode(\DIRECTORY_SEPARATOR, $parts);
    }

    public static function filesize($bytes, $decimals = 2)
    {
        $sz = 'BKMGTP';
        $sz = ['б', 'Кб', 'Мб', 'Гб', 'Тб'];
        $factor = floor((\strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / 1024** $factor) . @$sz[$factor];
    }

    public static function getPathParts($filename, $level = 2): array
    {
        $filenameParts = explode('/', $filename);
        $charCount = 2;
        // if($level * $charCount < count($filename)) {
        if ($level * $charCount < \count($filenameParts)) {
            $level = 0;
        }

        $parts = [];
        for ($i = 0; $i < $level; ++$i) {
            // $parts[] = substr($filename, $i * $charCount, $charCount);
            $parts[] = substr($filename, $i * $charCount, $charCount);
        }

        return $parts;
    }

    public static function createPath(array $parts): string
    {
        return implode(\DIRECTORY_SEPARATOR, $parts);
    }
}
