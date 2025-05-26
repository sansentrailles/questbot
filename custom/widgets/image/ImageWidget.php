<?php

declare(strict_types=1);

namespace app\custom\widgets\image;

use Yii;
use yii\widgets\InputWidget;

class ImageWidget extends InputWidget
{
    public $cropWidth;
    public $cropHeight;
    public $width;
    public $height;
    public $action;
    public $thumb;
    public $pathAttribute;
    public $withoutCrop = false;
    public $resizeWidth = 0;
    public $resizeHeight = 0;

    public function init(): void
    {
        parent::init();
        self::registerTranslations();

        $this->width ??= $this->cropWidth;
        $this->height ??= $this->cropHeight;
    }

    public function run()
    {
        $view = $this->getView();
        $assets = Asset::register($view);

        return $this->render('widget', [
            'model' => $this->model,
            'widget' => $this,
            'thumb' => $this->thumb,
            'pathAttribute' => $this->pathAttribute,
            'action' => $this->action,
            'options' => [
                'cropWidth' => $this->cropWidth,
                'cropHeight' => $this->cropHeight,
                'resizeWidth' => (int)$this->resizeWidth,
                'resizeHeight' => (int)$this->resizeHeight,
                'withoutCrop' => $this->withoutCrop,
                // 'width' => $this->width,
                // 'height' => $this->height,
            ],
        ]);
    }

    /**
     * Register widget translations.
     */
    public static function registerTranslations(): void
    {
        if (!isset(Yii::$app->i18n->translations['imager']) && !isset(Yii::$app->i18n->translations['imager/*'])) {
            Yii::$app->i18n->translations['imager'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@app/custom/widgets/image/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'imager' => 'imager.php',
                ],
            ];
        }
    }
}
