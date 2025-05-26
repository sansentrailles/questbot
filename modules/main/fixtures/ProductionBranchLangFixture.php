<?php

declare(strict_types=1);

namespace app\modules\main\fixtures;

use yii\test\ActiveFixture;

class ProductionBranchLangFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\main\models\ProductionBranchLang';
    public $depends = [
        'app\modules\main\fixtures\ProductionBranchFixture',
    ];
    public $dataFile = '@app/modules/main/fixtures/data/branch_lang.php';
}
