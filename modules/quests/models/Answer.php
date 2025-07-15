<?php

declare(strict_types=1);

namespace app\modules\quests\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\custom\traits\models\SortableTrait;
use app\custom\interfaces\annotations\Sortable;
use app\modules\quests\forms\backend\AnswerForm as Form;
use app\modules\quests\models\traits\AnswerAttributeLabelsTrait;

/**
 * This is the model class for table "{{%quest_task_answers}}".
 * @property int $id
 * @property int $task_id
 * @property string $title
 * @property int $is_right
 * @property int $created_at
 * @property int $updated_at
 */
class Answer extends ActiveRecord implements Sortable
{
    use AnswerAttributeLabelsTrait;
    use SortableTrait;

    public const STATE_RIGHT = 1;
    public const STATE_WRONG = 0;

    public static function tableName()
    {
        return 'quest_task_answers';
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

        $model->task_id  = $form->task_id;
        $model->title    = $form->title;
        $model->is_right = $form->is_right;

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->task_id  = $form->task_id;
        $this->title    = $form->title;
        $this->is_right = $form->is_right;
    }

    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    public function toggleRight()
    {
        return $this->is_right = $this->is_right ? self::STATE_WRONG : self::STATE_RIGHT;
    }

    public static function dropRightStates($taskId): void
    {
        self::updateAll(['is_right' => self::STATE_WRONG], [
            'and',
                ['=', 'is_right', self::STATE_RIGHT],
                ['task_id' => 2]
        ]);
    }
}
