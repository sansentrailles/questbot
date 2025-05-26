<?php

declare(strict_types=1);

namespace app\modules\main\fixtures;

use yii\test\ActiveFixture;

class SliderItemFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\main\models\SliderItem';
    public $dataFile = '@app/modules/main/fixtures/data/slider_item.php';
}
