<?php

declare(strict_types=1);

namespace app\modules\main\fixtures;

use yii\test\ActiveFixture;

class PresentationLangFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\main\models\PresentationLang';
    public $depends = [
        'app\modules\main\fixtures\PresentationFixture',
    ];
    public $dataFile = '@app/modules/main/fixtures/data/presentation_lang.php';
}
