<?php

declare(strict_types=1);

namespace app\modules\main\fixtures;

use yii\test\ActiveFixture;

class MainLinkFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\main\models\MainLink';
    public $depends = [
        'app\modules\catalog\fixtures\CategoryFixture',
    ];
    public $dataFile = '@app/modules/main/fixtures/data/link.php';
}
