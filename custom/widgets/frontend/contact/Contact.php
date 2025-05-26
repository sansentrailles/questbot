<?php

declare(strict_types=1);

namespace app\custom\widgets\frontend\contact;

use app\modules\contacts\models\Branch;
use app\modules\contacts\models\City;
use yii\base\Widget;

class Contact extends Widget
{
    public $template;

    public function init(): void
    {
        parent::init();
    }

    public function run()
    {
        if ($this->template === null) {
            $this->template = 'contact';
        }

        $city = City::getDefaultCity();

        return $this->render($this->template, [
            'city' => $city,
            'branch' => Branch::getDefault($city->id),
            'social' => $city->socialMedia,
        ]);
    }
}
