<?php

declare(strict_types=1);

namespace app\modules\settings\widgets\backend\fields;

use app\modules\settings\forms\backend\SettingEmailValueForm;
use yii\base\Widget;

/**
 * Displays string field.
 */
class EmailField extends Widget
{
    public $template;
    public $model;
    public $valueModels;
    public $form;
    public $settingId;

    public function init(): void
    {
        parent::init();
    }

    public function run()
    {
        if ($this->template === null) {
            $this->template = 'email';
        }

        $emptyModel = new SettingEmailValueForm();
        $emptyModel->setSetting($this->settingId);

        return $this->render($this->template, [
            'model' => $this->model,
            'valueModels' => $this->valueModels,
            'form' => $this->form,
            'emptyModel' => $emptyModel,
        ]);
    }
}
