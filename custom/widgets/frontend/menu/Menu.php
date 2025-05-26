<?php

declare(strict_types=1);

namespace app\custom\widgets\frontend\menu;

use yii\base\Widget;

class Menu extends Widget
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
            $this->template = 'menu';
        }

        return $this->render($this->template, []);
    }
}
