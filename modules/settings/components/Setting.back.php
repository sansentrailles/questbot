<?php

declare(strict_types=1);

namespace app\modules\settings\components;

use app\modules\settings\services\setting\SettingService;
use Yii;
use yii\base\Component;

class Setting extends Component
{
    public $time = 3600;
    private $settingService;

    public function __construct(SettingService $settingService, $config = [])
    {
        $this->settingService = $settingService;

        parent::__construct($config);
    }

    public function init(): void
    {
    }

    public function get($id, $caching = true)
    {
        $cache = Yii::$app->cache;
        $params = explode('.', $id);

        $key = $this->settingService->getKey($id);
        $val = $cache->get($key);
        if ($val && $caching) {
            return $val;
        }

        if (isset($params[1])) {
            $val = $this->settingService->get($params[0], $params[1]);
        } else {
            $val = $this->settingService->getGroup($params[0]);
        }

        $cache->set($key, $val, $this->time);

        return $val;
    }
}
