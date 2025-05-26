<?php

declare(strict_types=1);

namespace app\modules\main\fixtures;

use yii\test\ActiveFixture;

class EmployeeLangFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\main\models\EmployeeLang';
    public $depends = [
        'app\modules\main\fixtures\EmployeeFixture',
    ];
    public $dataFile = '@app/modules/main/fixtures/data/employee_lang.php';
}
