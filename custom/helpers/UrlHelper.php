<?php

declare(strict_types=1);

namespace app\custom\helpers;

use Yii;
use yii\helpers\Url;

class UrlHelper
{
    public static function CanonicalLangUrl($lang): void
    {
        $current = Url::current([], true);
        $pattern = "/\\/{$lang}/";
        $url = preg_replace($pattern, '', $current);

        Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => $url]);
    }

    // Refactor this
    public static function LangHome()
    {
        $langService = Yii::$container->get('app\modules\lang\interfaces\lang\ILangService');
        $lang = $langService->getCurrent();

        return '/' . $lang->code;
    }

    public static function siteURL()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] === 443) ? 'https://' : 'http://';
        $domainName = $_SERVER['HTTP_HOST'] . '/';
        return $protocol . $domainName;
    }
}
