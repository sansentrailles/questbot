<?php

declare(strict_types=1);

namespace app\custom\widgets\image;

use Imagine\Image\Box;
use Yii;
use yii\base\Action;
use yii\base\DynamicModel;
use yii\imagine\Image;
use yii\web\Response;
use yii\web\UploadedFile;

class UploadFileAction extends Action
{
    // public $uploadPath = 'uploads';

    public $extensions = 'jpeg, jpg, png, gif';
    // public $path = '@webroot/uploads/';
    public $path;
    public $url = '/uploads/';
    public $width;
    public $height;
    public $watermark = '@webroot/img/watermark.png';

    // todo создавать директорию если не существует
    // todo проверять право на запись в директорию
    // + todo присваивать уникальное имя для файла
    // + удалять загруженный файл
    // + сделать проверку, чтобы x и y были > 0
    // + сделать провреку, чтобы ширина и высота кропа не выступали за рамки картинки
    public function run()
    {
        // init
        $this->path = '@webroot' . $this->url;
        // \Tinify\setKey("Y1wfXTcgrY9eD_PatYE3PvBaX36V4fHT");

        $this->removeFiles();

        Yii::$app->response->format = Response::FORMAT_JSON;

        $file = UploadedFile::getInstanceByName('file');

        // TODO: Сделать правила валидации
        $model = new DynamicModel(compact('file'));
        $model->addRule('file', 'image', [
            // 'maxSize' => $this->maxSize,
            // 'tooBig' => Yii::t('cropper', 'TOO_BIG_ERROR', ['size' => $this->maxSize / (1024 * 1024)]),
            // 'extensions' => explode(', ', $this->extensions),
            // 'wrongExtension' => 'EXTENSION_ERROR', ['formats' => $this->extensions])
        ])->validate();

        if ($model->hasErrors()) {
            return [
                'error' => $model->getFirstError('file'),
            ];
        }

        if (file_exists(Yii::getAlias($this->path)) === false) {
            mkdir(Yii::getAlias($this->path), 0777, true);
        }

        $request = Yii::$app->request;

        $quality = $request->post('quality', 60);

        if (($validate = $this->validateData($request->post())) !== false) {
            return $validate;
        }

        if ($request->post('croppedFile')) {
            if (file_exists(Yii::getAlias('@webroot') . $request->post('croppedFile'))) {
                unlink(Yii::getAlias('@webroot') . $request->post('croppedFile'));
            }
            $croppedFile = '';
        }

        $model->file->name = uniqid() . '.' . $model->file->extension;

        ini_set('memory_limit', '256M');
        // crop image
        $image = Image::crop(
            $file->tempName . $request->post('filename'),
            $request->post('cropWidth'),
            $request->post('cropHeight'),
            [(int)$request->post('x'), (int)$request->post('y')]
        );

        $size = $image->getSize();

        $resizeOptions = $this->getResizeOptions($request->post(), $size);
        $width = $resizeOptions['width'];
        $height = $resizeOptions['height'];
        // print_r([
        //     'this-width' => $this->width,
        //     'this-height' => $this->height,
        //     'width' => $width,
        //     'height' => $height,
        // ]);
        // exit;
        // if($this->width && $this->height && ($this->width != $size->getWidth() || $this->height != $size->getHeight())) {
        if ($width && $height && ($width !== $size->getWidth() || $height !== $size->getHeight())) {
            $image->resize(
                // new Box($request->post('width'), $request->post('height'))
                // new Box($this->width, $this->height)
                new Box($width, $height)
            );
        }

        if ($image = $image->save(Yii::getAlias($this->path) . $model->file->name, ['quality' => $quality])) {
            // tiny png
            // $source = \Tinify\fromFile(Yii::getAlias($this->path) . $model->file->name);
            // $source->toFile(Yii::getAlias($this->path).'compressed.jpg');

            // if($this->watermark) {
            //     $image = Image::watermark($image, Yii::getAlias($this->watermark));
            //     $image = $image->save(Yii::getAlias($this->path) . $model->file->name);
            // }

            $result = [
                'filePath' => $this->url . $model->file->name,
                // 'filePath' => $this->url . 'compressed.jpg'
            ];
        } else {
            $result = [
                'error' => 'ERROR_CAN_NOT_UPLOAD_FILE',
                'filePath' => $croppedFile,
            ];
        }

        return $result;
    }

    private function removeFiles(): void
    {
        foreach (glob(Yii::getAlias($this->path) . '*') as $file) {
            if (filemtime($file) < (time() - 3600)) {
                unlink($file);
            }
        }
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

        // image size from params
        if ($resizeWidth === 0 && $resizeHeight === 0) {
            $width = (int)$this->width;
            $height = (int)$this->height;
        // image size from crop params
        } elseif ($resizeWidth > 0 || $resizeHeight > 0) {
            if ($resizeWidth === 0) {
                $height = $resizeHeight;
                $width = (int)($imageWidth * $resizeHeight/$imageHeight);
            } elseif ($resizeHeight === 0) {
                $width = $resizeWidth;
                $height = (int)($imageHeight * $resizeWidth/$imageWidth);
            }
        }

        return [
            'width' => $width,
            'height' => $height,
        ];
    }
}
