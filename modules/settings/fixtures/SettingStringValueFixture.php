<?php

declare(strict_types=1);

namespace app\modules\settings\fixtures;

use yii\test\ActiveFixture;

class SettingStringValueFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\settings\models\SettingStringValue';
    public $depends = ['app\modules\settings\fixtures\SettingFixture'];
    public $dataFile = '@app/modules/settings/fixtures/data/setting_string.php';
}
