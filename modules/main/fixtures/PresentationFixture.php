<?php

declare(strict_types=1);

namespace app\modules\main\fixtures;

use yii\test\ActiveFixture;

class PresentationFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\main\models\Presentation';
    public $dataFile = '@app/modules/main/fixtures/data/presentation.php';
}
