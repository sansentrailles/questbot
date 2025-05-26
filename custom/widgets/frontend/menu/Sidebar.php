<?php

declare(strict_types=1);

namespace app\custom\widgets\frontend\menu;

use yii\base\Widget;

class Sidebar extends Widget
{
    public $template;
    public $subcontent;
    public $submenu;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function init(): void
    {
        parent::init();
    }

    public function run()
    {
        if ($this->template === null) {
            $this->template = 'sidebar';
        }

        return $this->render($this->template, [
            'subcontent' => $this->subcontent,
        ]);
    }
}
