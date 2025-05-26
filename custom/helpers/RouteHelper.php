<?php

declare(strict_types=1);

namespace app\custom\helpers;

use Yii;

/**
 * A set of methods used for defining a route.
 *
 *  @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */
class RouteHelper
{
    public static function isRoute($route)
    {
        $controller = Yii::$app->controller;
        $module = $controller->module;
        $action = $controller->action;
        return $route === $module->id . '/' . $controller->id . '/' . $action->id;
    }

    public static function isModule($module)
    {
        return Yii::$app->controller->module->id === $module;
    }

    public static function isAction($action)
    {
        return Yii::$app->controller->action->id === $action;
    }

    public static function isHome()
    {
        return Yii::$app->request->url === '/';
        // $controller = Yii::$app->controller;
        // $default_controller = Yii::$app->defaultRoute;
        // return $controller->id === $default_controller && $controller->action->id === $controller->defaultAction;
    }
}
