<?php

declare(strict_types=1);

namespace app\modules\settings\fixtures;

use yii\test\ActiveFixture;

class SettingFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\settings\models\Setting';
    public $depends = ['app\modules\settings\fixtures\SettingGroupFixture'];
    public $dataFile = '@app/modules/settings/fixtures/data/setting.php';
}
