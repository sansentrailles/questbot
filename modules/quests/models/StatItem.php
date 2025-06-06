<?php

declare(strict_types=1);

namespace app\modules\quests\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\modules\quests\forms\backend\StatItemForm as Form;
use app\modules\quests\models\traits\StatItemAttributeLabelsTrait;

/**
 * This is the model class for table "{{%quest_stat_items}}".
 * @property int $id
 * @property int $stat_id
 * @property int $task_id
 * @property string $question
 * @property string $task_answer
 * @property string $user_answer
 * @property int $is_correct
 * @property int $hint_used
 */
class StatItem extends ActiveRecord
{
    use StatItemAttributeLabelsTrait;

    public static function tableName()
    {
        return 'quest_stat_items';
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

        $model->stat_id     = $form->stat_id;
        $model->task_id     = $form->task_id;
        $model->question    = $form->question;
        $model->task_answer = $form->task_answer;
        $model->user_answer = $form->user_answer;
        $model->is_correct  = $form->is_correct;
        $model->hint_used   = $form->hint_used;

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->stat_id     = $form->stat_id;
        $this->task_id     = $form->task_id;
        $this->question    = $form->question;
        $this->task_answer = $form->task_answer;
        $this->user_answer = $form->user_answer;
        $this->is_correct  = $form->is_correct;
        $this->hint_used   = $form->hint_used;
    }

    public function getStat()
    {
        return $this->hasOne(Stat::class, ['id' => 'stat_id']);
    }

    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }
}
