<?php

declare(strict_types=1);

namespace app\modules\main\fixtures;

use yii\test\ActiveFixture;

class MainLinkLangFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\main\models\MainLinkLang';
    public $depends = [
        'app\modules\main\fixtures\MainLinkFixture',
    ];
    public $dataFile = '@app/modules/main/fixtures/data/link_lang.php';
}
