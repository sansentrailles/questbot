<?php

declare(strict_types=1);

namespace app\modules\quests\services;

use yii\base\Model as Form;
use app\custom\services\base\BaseService;
use app\modules\quests\models\StatItem as Model;
use app\modules\quests\forms\backend\StatItemForm;
use app\modules\quests\repositories\StatItemRepository as Repository;

class StatItemService extends BaseService
{
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

    public function saveStatItem(Model $model)
    {
        $form = new StatItemForm($model);

        return $this->save($form);
    }

    public function saveItem($stat_id, $task, string $answer, bool $is_correct)
    {
        $statItem = $this->repository->getItem($stat_id, $task->id);
        $form = new StatItemForm($statItem);

        $form->stat_id = $stat_id;
        $form->task_id = $task->id;
        $form->question = $task->question;
        $form->task_answer = $task->answerText;
        $form->user_answer = $answer;
        $form->is_correct = $is_correct;

        // if ($task->image) {
        //     $this->prepareFiles($task->imagePath);
        // }

        if ($statItem == null) {
            $hints = $task->visibleHints;
            $form->hint_count = count($hints);
        }

        return $this->save($form);
    }

    public function incrementHints($statId, $taskId)
    {
        $statItem = $this->repository->getItem($statId, $taskId);
        $form = new StatItemForm($statItem);

        $form->hint_count += 1;

        return $this->save($form);
    }

    private function prepareFiles(string $path)
    {
        $fullpath = \Yii::getAlias("@webroot").$path;

        $formName = 'StatItemForm';
        $attribute = 'taskImageFile';


        $_FILES[$formName]['name'][$attribute] = pathinfo($fullpath, PATHINFO_BASENAME);
        $_FILES[$formName]['type'][$attribute] = mime_content_type($fullpath);
        $_FILES[$formName]['tmp_name'][$attribute] = $fullpath;
        $_FILES[$formName]['error'][$attribute] = 0;
        $_FILES[$formName]['size'][$attribute] = filesize($fullpath);
    }

    /*
    $options['name'][$attribute] = pathinfo($path, PATHINFO_BASENAME);
        $options['type'][$attribute] = mime_content_type($path);
        // $options['tmp_name'][$attribute] = str_replace("/", "\\", $path);
        $options['tmp_name'][$attribute] = str_replace("\\", "/", $path);
        // $options['tmp_name'][$attribute] = $path;
        $options['error'][$attribute] = 0;
        $options['size'][$attribute] = filesize($path);
     */
}
