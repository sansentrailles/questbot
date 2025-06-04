<?php

declare(strict_types=1);

namespace app\modules\quests\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\modules\quests\forms\backend\UserProgressForm as Form;
use app\modules\quests\models\traits\UserProgressAttributeLabelsTrait;

/**
 * This is the model class for table "{{%quest_user_progress}}".
 * @property int $id
 * @property int $user_id
 * @property int $quest_id
 * @property int $curretn_question_id
 * @property string $answer
 * @property int $is_completed
 * @property int $created_at
 * @property int $updated_at
 */
class UserProgress extends ActiveRecord
{
    // use UserProgressAttributeLabelsTrait;

    public const STATE_COMPLETED = 1;
    public const STATE_NOT_COMPLETED = 0;


    public static function tableName()
    {
        return 'quest_user_progress';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public static function add(Form $form)
    {
        $model = new self();

        $model->quest_id        = $form->quest_id;
        $model->user_id         = $form->user_id;
        $model->current_task_id = $form->current_task_id;
        $model->is_completed    = $form->is_completed;
        $model->answer          = $form->answer;

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->quest_id        = $form->quest_id;
        $this->user_id         = $form->user_id;
        $this->current_task_id = $form->current_task_id;
        $this->is_completed    = $form->is_completed;
        $this->answer          = $form->answer;
    }

    public function getQuest()
    {
        return $this->hasOne(Quest::class, ['id' => 'quest_id']);
    }

    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'current_task_id']);
    }
}
