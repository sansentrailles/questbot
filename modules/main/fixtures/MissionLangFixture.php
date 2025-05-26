<?php

declare(strict_types=1);

namespace app\modules\main\fixtures;

use yii\test\ActiveFixture;

class MissionLangFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\main\models\MissionLang';
    public $depends = [
        'app\modules\main\fixtures\MissionFixture',
    ];
    public $dataFile = '@app/modules/main/fixtures/data/mission_lang.php';
}
