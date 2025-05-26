<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\arrayField\helpers;

class ErrorHelper
{
    public static function getErrors($model, $attribute, $field, $rowNumber)
    {
        if (!$model->hasErrors()) {
            return [];
        }

        $errors = $model->getErrors();

        if (!isset($errors[$attribute])) {
            return [];
        }

        $fieldErrors = [];
        foreach ($errors[$attribute] as $error) {
            if (isset($error[$rowNumber], $error[$rowNumber][$field])) {
                $fieldErrors = $error[$rowNumber][$field];
                break;
            }
        }

        return $fieldErrors;
    }
}
