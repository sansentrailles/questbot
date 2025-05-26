<?php

declare(strict_types=1);

namespace app\modules\main\fixtures;

use yii\test\ActiveFixture;

class MissionFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\main\models\Mission';
    public $dataFile = '@app/modules/main/fixtures/data/mission.php';
}
