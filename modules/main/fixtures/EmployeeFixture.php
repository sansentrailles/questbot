<?php

declare(strict_types=1);

namespace app\modules\main\fixtures;

use yii\test\ActiveFixture;

class EmployeeFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\main\models\Employee';
    public $dataFile = '@app/modules/main/fixtures/data/employee.php';
}
