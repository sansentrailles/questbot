<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\cropper;

use Imagine\Image\Box;
use Yii;
use yii\base\Action;
use yii\base\DynamicModel;
use yii\imagine\Image;
use yii\web\Response;
use yii\web\UploadedFile;

class UploadFileAction extends Action
{
    public $alias =  '@webroot';
    public $storage = '/tmp/';
    public $quality = 100;
    public $width;
    public $height;
    public $extensions = ['jpg', 'jpeg', 'png'];
    public $maxSize = 10485760; // 10Мб

    public function run()
    {
        ini_set('memory_limit', '256M');
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        // remove old cropped files
        $this->removeFiles();
        if (($storagePath = $this->getImageStoragePath()) === false) {
            return [
                'status' => 'error',
                'message' => 'Storage path not found',
            ];
        }

        $file = UploadedFile::getInstanceByName('file');
        $model = new DynamicModel(compact('file'));
        $model->addRule('file', 'image', [
            'maxSize' => $this->maxSize,
            'checkExtensionByMimeType' => false,
            // 'tooBig' => Yii::t('cropper', 'TOO_BIG_ERROR', ['size' => $this->maxSize / (1024 * 1024)]),
            'extensions' => $this->extensions,
            // 'wrongExtension' => 'EXTENSION_ERROR', ['formats' => $this->extensions])
        ])->validate();

        if ($model->hasErrors()) {
            print_r($model->errors);
            exit;
            return [
                'error' => $model->getFirstError('file'),
            ];
        }

        // del prev cropped file
        if ($request->post('prevCroppedFile')) {
            if (file_exists(Yii::getAlias($this->alias) . $request->post('prevCroppedFile'))) {
                unlink(Yii::getAlias($this->alias) . $request->post('prevCroppedFile'));
            }

            $croppedFile = '';
        }

        if (($validate = $this->validateData($request->post())) !== false) {
            return $validate;
        }

        // crop image
        $image = Image::crop(
            $file->tempName . $request->post('filename'),
            $request->post('cropWidth'),
            $request->post('cropHeight'),
            [(int)$request->post('x'), (int)$request->post('y')]
        );

        // current image size
        $size = $image->getSize();

        // get resize values
        $resizeOptions = $this->getResizeOptions($request->post(), $size);
        $width = $resizeOptions['width'];
        $height = $resizeOptions['height'];

        if ($width && $height && ($width !== $size->getWidth() || $height !== $size->getHeight())) {
            $image->resize(
                new Box($width, $height)
            );
        }

        $filename = $this->getFileName($model);

        if ($image = $image->save($storagePath . $filename, ['quality' => $this->quality])) {
            $result = [
                'filePath' => $this->storage . $filename,
            ];
        } else {
            $result = [
                'error' => 'ERROR_CAN_NOT_UPLOAD_FILE',
                'filePath' => $croppedFile,
            ];
        }

        return $result;
    }

    private function validateData($data)
    {
        $x = (int)$data['x'];
        $y = (int)$data['y'];

        if ($x < 0 || $y < 0) {
            return ['error' => 'Кроп должен быть в пределах изображения'];
        }

        if (
            // ($x + $data['width']) > $data['naturalWidth'] ||
            // ($y + $data['height'] > $data['naturalHeight'])
            ($x + $data['cropWidth']) > $data['naturalWidth'] ||
            ($y + $data['cropHeight'] > $data['naturalHeight'])
        ) {
            return ['error' => 'Кроп должен быть в пределах изображения'];
        }

        return false;
    }

    private function getResizeOptions($post, $size)
    {
        $resizeWidth = $post['resizeWidth'] ?? 0;
        $resizeHeight = $post['resizeHeight'] ?? 0;

        $imageWidth = $size->getWidth();
        $imageHeight = $size->getHeight();

        // image size from widget params
        if ($resizeWidth === 0 && $resizeHeight === 0) {
            $width = (int)$this->width;
            $height = (int)$this->height;
        // image size from crop params
        } else { // if($resizeWidth > 0 || $resizeHeight > 0)
            if ($resizeWidth === 0) {
                $height = $resizeHeight;
                $width = (int)($imageWidth * $resizeHeight/$imageHeight);
            } elseif ($resizeHeight === 0) {
                $width = $resizeWidth;
                $height = (int)($imageHeight * $resizeWidth/$imageWidth);
            } else {
                $width = $resizeWidth;
                $height = $resizeHeight;
            }
        }

        return [
            'width' => $width,
            'height' => $height,
        ];
    }

    private function getFileName($model)
    {
        return uniqid() . '.' . $model->file->extension;
    }

    private function getImageStoragePath()
    {
        $storagePath = Yii::getAlias($this->alias) . $this->storage;
        if (file_exists($storagePath) === false) {
            mkdir($storagePath, 0777, true);
        }

        if (file_exists($storagePath) === false) {
            return false;
        }

        return $storagePath;
    }

    private function removeFiles()
    {
        if (($storagePath = $this->getImageStoragePath()) === false) {
            return false;
        }

        foreach (glob($storagePath . '*') as $file) {
            if (filemtime($file) < (time() - 3600)) {
                unlink($file);
            }
        }
    }
}
