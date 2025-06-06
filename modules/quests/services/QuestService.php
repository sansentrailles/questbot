<?php

declare(strict_types=1);

namespace app\modules\quests\services;

use app\custom\helpers\StorageFileHelper;
use app\custom\services\base\BaseService;
use app\modules\quests\models\Quest as Model;
use app\modules\quests\repositories\QuestRepository as Repository;
use yii\base\Model as Form;

class QuestService extends BaseService
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

    public function deleteImage($id): void
    {
        $model = $this->repository->find($id);
        $files = $model->getImageFiles();
        StorageFileHelper::removeFiles($files);
        $model->image = null;
        $this->repository->save($model);
    }

    public function deleteImageFinal($id): void
    {
        $model = $this->repository->find($id);
        $files = $model->getImageFinalFiles();
        StorageFileHelper::removeFiles($files);
        $model->image_final = null;
        $this->repository->save($model);
    }

    /**
     * Generate array for telegram bot keyboard with quests
     */
    public function generateQuestKeyboard(array $quests)
    {
        $lines = [];
        foreach ($quests as $quest) {
            $lines[] = [
                'text' => $quest->title,
                'callback_data' => 'quest_info:' . $quest->id,
            ];
        }

        $inlineKeyboard = [];
        foreach ($lines as $button) {
            $inlineKeyboard[] = [$button];
        }

        $result['inline_keyboard'] = $inlineKeyboard;

        return $result;

    }

    /** Generate array for telegram bot keyboard with questions for quest */
    // public function generateTasksKeyboard(array $tasks)
    // {
    //     $lines = [];
    //     foreach ($tasks as $task) {
    //         $lines[] = [
    //             'text' => $task->question,
    //             'callback_data' => 'show_quest:' . $task->id,
    //         ];
    //     }

    //     $lines[] = [
    //             'text' => '⬅️ К списку квестов',
    //             'callback_data' => 'quests',
    //         ];

    //     $inlineKeyboard = [];
    //     foreach ($lines as $button) {
    //         $inlineKeyboard[] = [$button];
    //     }

    //     $result['inline_keyboard'] = $inlineKeyboard;

    //     return $result;
    // }

    public function toggleVisible($id)
    {
        $model = $this->repository->find($id);
        $state = $model->toggleVisible();
        $this->repository->save($model);

        return $state;
    }

    public function getVisible()
    {
        return $this->repository->getVisible();
    }

}
