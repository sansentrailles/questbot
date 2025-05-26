<?php

declare(strict_types=1);
/**
 * @see http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\custom\helpers;

use Yii;

/**
 * AppHelper provides additional functionality for app.
 *
 * @author
 * @since
 */
class AppHelper
{
    public static function getManifestData($fileName, $resourceName)
    {
        $file = Yii::getAlias('@app') . '/manifest/' . $fileName;

        if (!file_exists($file)) {
            return $resourceName;
        }

        $data = json_decode(file_get_contents($file), true);

        if (empty($data[$resourceName])) {
            return $resourceName;
        }

        return $data[$resourceName];
    }
}
