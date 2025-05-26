<?php

declare(strict_types=1);

namespace app\custom\widgets\frontend\menu\helpers;

use yii\helpers\Url;

class MenuHelper
{
    public static function isHovered($item, $submenuItems)
    {
        if (\is_array($submenuItems) === false) {
            return false;
        }

        $isHovered = false;
        $current = urldecode(Url::current());
        foreach ($submenuItems as $submenuItem) {
            if (str_contains($current, $submenuItem['url'])   || str_contains($current, $item->getPath())) {
                $isHovered = true;
                break;
            }
        }

        return $isHovered;
    }
}
