<?php

declare(strict_types=1);

namespace app\custom\widgets\image;

use Yii;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\helpers\FileHelper;

class ImageBehavior extends Behavior
{
    public $storePath = 'files';
    public $attribute;

    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            BaseActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    /**
     * This method is called at the end of inserting or updating a record.
     * @param mixed $event
     * @throws \yii\base\InvalidParamException
     */
    // todo заменить явное имея атрибута thumb на динамическое
    public function beforeSave($event)
    {
        $model = $this->owner;

        $attribute = $this->owner->{$this->attribute};
        if ($attribute === false) {
            return true;
        }

        if ($model->getOldAttribute($this->attribute) && $model->getOldAttribute($this->attribute) !== $model->{$this->attribute}) {
            // $oldFilePath = Yii::getAlias('@webroot').'/'.$this->storePath.'/'.$model->getOldAttribute($this->attribute);
            // if(file_exists($oldFilePath)) {
            //     unlink($oldFilePath);
            // }

            $subdirs = $this->getSubdirs($model->getOldAttribute($this->attribute));
            $oldFilePath = Yii::getAlias('@webroot') . '/' . $this->storePath . '/' . $subdirs . '/' . $model->getOldAttribute($this->attribute);

            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        } elseif ($model->getOldAttribute($this->attribute) === $model->{$this->attribute}) {
            return true;
        }
        // $newPath = $this->storePath.'/'.$this->owner->thumb;

        $pathPrefix[] = random_int(10, 99);
        $pathPrefix[] = random_int(10, 99);

        $path = Yii::getAlias('@webroot') . '/' . $this->storePath . '/' . implode('/', $pathPrefix);
        if (!file_exists($path)) {
            FileHelper::createDirectory($path, 777);
        }

        if ($attribute === null) {
            return false;
        }

        $tmp = explode('/', $attribute);
        [$name, $ext] = explode('.', end($tmp));

        $newName = implode('', $pathPrefix) . uniqid() . '.' . $ext;
        $newPath = '/' . $this->storePath . '/' . implode('/', $pathPrefix) . '/' . $newName;
        $newAbsolutePath = Yii::getAlias('@webroot') . $newPath;
        $oldAbsolutePath = Yii::getAlias('@webroot') . $attribute;

        if (rename($oldAbsolutePath, $newAbsolutePath)) {
            $model->setAttribute($this->attribute, $newName);
        }
    }

    public function beforeDelete(): void
    {
        $filePath = Yii::getAlias('@webroot') . $this->getFileUrl($this->attribute);
        if ($this->owner->{$this->attribute} && file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function getFileUrl($attribute)
    {
        $filename = $this->owner->{$this->attribute};
        // $fileDirs = substr($fileName, 0, 2).'/'.substr($fileName, 2,2);
        return '/' . $this->storePath . '/' . $this->getSubdirs($filename) . '/' . $this->owner->{$this->attribute};
    }

    private function getSubdirs($filename)
    {
        return substr($filename, 0, 2) . '/' . substr($filename, 2, 2);
    }
}
