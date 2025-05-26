<?php

declare(strict_types=1);

namespace app\modules\settings\services;

use app\custom\services\base\BaseService;
// use app\modules\settings\forms\backend\SettingUploadedFileValueForm as Form;
use yii\base\Model as Form;
use app\modules\settings\models\SettingUploadedFileValue as Model;
use app\modules\settings\repositories\SettingUploadedFileValueRepository as Repository;

class SettingUploadedFileValueService extends BaseService
{
    public function saveValues(array $forms): void
    {
        $files = $_FILES;
        foreach ($forms as $k => $form) {
            $this->prepareFilesArray($k, $files, 'valueFile');
            $this->save($form);
        }
    }

    public function create(Form $form)
    {
        $model = Model::add($form);
        $this->repository->add($model);
        return $model;
    }

    public function edit(Form $form)
    {
        $model = $this->repository->find($form->id);
        $model->edit($form);
        $this->repository->save($model);

        return $model;
    }

    public function getRepositoryClass()
    {
        return Repository::class;
    }

    private function prepareFilesArray($index, $files, $attribute)
    {
        unset($_FILES);
        $formName = array_keys($files)[0];

        if (!$files[$formName]['name'][$index][$attribute]) {
            return false;
        }

        $_FILES[$formName]['name'][$attribute] = $files[$formName]['name'][$index][$attribute];
        $_FILES[$formName]['type'][$attribute] = $files[$formName]['type'][$index][$attribute];
        $_FILES[$formName]['tmp_name'][$attribute] = $files[$formName]['tmp_name'][$index][$attribute];
        $_FILES[$formName]['error'][$attribute] = 0;
        $_FILES[$formName]['size'][$attribute] = $files[$formName]['size'][$index][$attribute];
    }
}
