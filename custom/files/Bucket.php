<?php

declare(strict_types=1);

namespace app\custom\files;

use app\custom\files\exceptions\BucketNotFoundException;
use app\custom\helpers\FileHelper;
use Yii;
use yii\helpers\FileHelper as SystemFileHelper;

// use App\Custom\Helpers\Files\FileStorage;
// use Illuminate\Support\Facades\Storage;

class Bucket
{
    private $bucket = [];
    private $fileManager;

    private $configParam = 'buckets';

    public function __construct(string $bucketName)
    {
        $config = Yii::$app->params['buckets'] ?? null;
        if (null === $config) {
            throw new BucketNotFoundException('Config not found.');
        }

        $this->bucket = $config[$bucketName];

        if (null === $this->bucket) {
            throw new BucketNotFoundException('Bucket not found.');
        }

        $this->fileManager = Yii::$container->get('app\custom\files\FileManager');
    }

    public function __toString()
    {
        return $this->bucket;
    }

    // private function getBucketParamsName($bucketName)
    // {
    //     return "{$this->configName}.{$bucketName}";
    // }

    public function getFileUrl($fileName)
    {
        $directory = $this->bucket['baseSubPath'];
        $parts = FileHelper::getPathParts($fileName, 3);
        return '/' . FileHelper::createPath([
            'files',
            $directory,
            FileHelper::createPath($parts),
            $fileName,
        ]);
    }

    public function copyFileIn($file, $fileName)
    {
        $filePath = SystemFileHelper::normalizePath($this->getFileUrl($fileName));
        $fileDir = \dirname($filePath);
        $webroot = Yii::getAlias('@webroot');

        if ($this->fileManager->exists($fileDir) === false) {
            $this->fileManager->createDirectory($webroot . $fileDir);
        }

        return $this->fileManager->put($webroot . $filePath, $this->fileManager->get($file));
    }

    public function deleteFile($fileName)
    {
        if (!$fileName) {
            return false;
        }

        $path = $this->getFileUrl($fileName);

        $webroot = Yii::getAlias('@webroot');
        $fullpath = $webroot . $path;
        if ($this->fileManager->exists($fullpath)) {
            return $this->fileManager->delete($fullpath);
        }

        return false;
    }
}
