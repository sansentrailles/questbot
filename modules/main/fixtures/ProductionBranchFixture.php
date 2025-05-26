<?php

declare(strict_types=1);

namespace app\modules\main\fixtures;

use yii\test\ActiveFixture;

class ProductionBranchFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\main\models\ProductionBranch';
    public $dataFile = '@app/modules/main/fixtures/data/branch.php';
}
