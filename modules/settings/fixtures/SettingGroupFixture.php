<?php

declare(strict_types=1);

namespace app\modules\settings\fixtures;

use yii\test\ActiveFixture;

class SettingGroupFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\settings\models\SettingGroup';
    public $dataFile = '@app/modules/settings/fixtures/data/group.php';
}
