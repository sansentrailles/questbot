<?php

declare(strict_types=1);

namespace app\modules\catalog\fixtures;

use yii\test\ActiveFixture;

class LabelLangFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\catalog\models\LabelLang';
    public $depends = ['app\modules\catalog\fixtures\LabelFixture'];
    public $dataFile = '@app/modules/catalog/fixtures/data/label_lang.php';
}
