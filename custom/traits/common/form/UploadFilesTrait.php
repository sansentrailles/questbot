<?php

declare(strict_types=1);

namespace app\custom\traits\common\form;

use app\custom\helpers\FileHelper;
use app\custom\helpers\UploadFileHelper;
use Closure;
use Yii;
use yii\web\UploadedFile;

trait UploadFilesTrait
{
    /**
     * returns a map of the virtual attributes to the attributes
     * with the appropriate transformations to the certain attribute
     * options array have the next structure.
     *
     * ```php
     * [
     *      'virtualAttribute' => [
     *          'attribute' => [
     *              'transform' => [
     *                 function (UploadedFile $uploadedFile, FileStorage $fileStorage, $file, $oldFile) {},
     *                 ...
     *              ],
     *          ],
     *          ...
     *      ],
     *      ...
     * ]
     * ```
     *
     * virtual attribute is an UploadedFile class instance
     * @return array options
     * @author Chistyakov Ilya <ichistyakovv@gmail.com>
     */
    abstract public function getUploadOptions();

    public function prepareFiles($file, $attribute, $alias = null)
    {
        if ($alias !== null) {
            $filepath = Yii::getAlias($alias) . $this->{$file};
        } else {
            $filepath = $this->{$file};
        }

        if (filetype($filepath) === 'dir') {
            return false;
        }

        if (file_exists($filepath) === false) {
            return false;
        }

        $formName = \yii\helpers\StringHelper::basename(static::class);

        $_FILES[$formName]['name'][$attribute] = basename($filepath);
        $_FILES[$formName]['type'][$attribute] = mime_content_type($filepath);
        // $_FILES[$formName]['tmp_name'][$attribute] = str_replace("/", "\\", $filepath);
        $_FILES[$formName]['tmp_name'][$attribute] = $filepath;
        $_FILES[$formName]['error'][$attribute] = 0;
        $_FILES[$formName]['size'][$attribute] = filesize($filepath);

        return true;
    }

    public function upload(): void
    {
        // if (!Yii::$app->request->isPost)
        //     return false;

        $options = $this->getUploadOptions();

        foreach ($options as $virtualAttribute => $attributes) {
            foreach ($attributes as $attribute => $attrOptions) {
                if (empty($attrOptions['virtualFiles'])) {
                    break;
                }

                foreach ($attrOptions['virtualFiles'] as $fileParams) {
                    $file = $fileParams['filename'];
                    $attribute = $fileParams['attribute'];
                    $alias = $fileParams['alias'];

                    $this->prepareFiles($file, $attribute, $alias);
                }
            }
        }

        foreach ($options as $virtualAttribute => $attributes) {
            $this->{$virtualAttribute} = UploadedFile::getInstance($this, $virtualAttribute);

            if (!$this->{$virtualAttribute}) {
                continue;
            }

            foreach ($attributes as $attribute => $attrOptions) {
                if (!isset($attrOptions['transform'])) {
                    continue;
                }

                $file = $this->{$virtualAttribute}->tempName;

                $callbacks = [];

                array_unshift($attrOptions['transform'], UploadFileHelper::generateTempFile());
                foreach ($attrOptions['transform'] as $callable) {
                    if ($callable instanceof Closure) {
                        $result = \call_user_func($callable, $this, $this->{$virtualAttribute}, $file, $this->{$attribute});
                        // $result = call_user_func($callable, $this, $this->$virtualAttribute, Yii::$app->fileStorage, $file, $this->$attribute);

                        if (\is_array($result)) {
                            [$file, $callback] = $result;
                            $callbacks[] = $callback;
                        } else {
                            $file = $result;
                        }
                    }
                }

                foreach ($callbacks as $callback) {
                    if ($callback instanceof Closure) {
                        \call_user_func($callback);
                    }
                }

                if ($file !== false) {
                    $this->{$attribute} = $file;
                }

                // FileHelper::deleteFile($this->$virtualAttribute->tempName);
            }
            // FileHelper::deleteFile($this->$virtualAttribute->tempName);
            unlink($this->{$virtualAttribute}->tempName);
        }

        UploadedFile::reset();
    }
}
