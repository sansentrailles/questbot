<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\cropper;

use yii\widgets\InputWidget;

class Cropper extends InputWidget
{
    public $cropWidth;
    public $cropHeight;
    public $resizeWidth;
    public $resizeHeight;
    public $height;
    public $action;
    public $thumb;
    public $withoutCrop = false;

    public function init(): void
    {
        parent::init();

        $this->resizeWidth ??= $this->cropWidth;
        $this->resizeHeight ??= $this->cropHeight;
    }

    public function run()
    {
        $view = $this->getView();
        $assets = Asset::register($view);

        $options = [
            'cropWidth' => $this->cropWidth,
            'cropHeight' => $this->cropHeight,
            'resizeWidth' => $this->resizeWidth,
            'resizeHeight' => $this->resizeHeight,
            'withoutCrop' => $this->withoutCrop,
        ];

        return $this->render('cropper', [
            'model'   => $this->model,
            'widget'  => $this,
            'action'  => $this->action,
            'thumb'   => $this->thumb,
            'options' => $options,
        ]);
    }
}
