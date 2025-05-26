<?php

declare(strict_types=1);

namespace app\custom\widgets\frontend\scripts;

use Yii;
use yii\base\Widget;

class ExternalScripts extends Widget
{
    public $template;

    public function __construct(
        $config = []
    ) {
        parent::__construct($config);
    }

    public function init(): void
    {
        parent::init();
    }

    public function run()
    {
        if ($this->template === null) {
            $this->template = 'scripts';
        }

        $yandexMetrika = Yii::$app->setting->get('scripts.ya-metrika');

        return $this->render($this->template, [
            'yandex' => $yandexMetrika,
        ]);
    }
}
