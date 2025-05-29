<?php

declare(strict_types=1);

namespace app\modules\quests\forms\backend;

use yii\base\Model;
use app\modules\quests\models\Answer;
use app\modules\quests\models\Task;
use app\modules\quests\models\traits\AnswerAttributeLabelsTrait;

class AnswerForm extends Model
{
    use AnswerAttributeLabelsTrait;

    public $id;
    public $task_id;
    public $is_right;
    public $title;

    private $answer;

    public function __construct(?Answer $answer = null, $config = [])
    {
        $this->answer = $answer;
        parent::__construct($config);
    }



    public function init(): void
    {
        if (!$this->answer) {
            return;
        }

        $this->id        = $this->answer->id;
        $this->task_id   = $this->answer->task_id;
        $this->title     = $this->answer->title;
        $this->is_right  = $this->answer->is_right;
    }

    public function rules()
    {
        return [
            [['is_right'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::class,
                'targetAttribute' => ['task_id' => 'id'],
            ],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->answer) {
            return $this->answer->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->answer) {
            return false;
        }

        return true;
    }

    public function setTask($id)
    {
        $this->task_id = $id;
    }
}
