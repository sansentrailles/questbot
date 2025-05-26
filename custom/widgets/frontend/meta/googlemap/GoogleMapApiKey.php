<?php

declare(strict_types=1);

namespace app\custom\widgets\frontend\meta\googlemap;

use Yii;
use yii\base\Widget;

class GoogleMapApiKey extends Widget
{
    public function init(): void
    {
        parent::init();
    }

    public function run()
    {
        $key = Yii::$app->setting->get('api.google_map');

        return $this->render('meta', [
            'key' => $key,
        ]);
    }
}
