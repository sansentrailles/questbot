<?php

declare(strict_types=1);

namespace app\modules\quests\forms\backend;

use yii\base\Model;
use app\custom\files\BaseImageFile;
use app\modules\quests\models\Stat;
use app\modules\quests\models\Task;
use app\modules\quests\models\StatItem;
use app\custom\traits\common\form\UploadFilesTrait;
use app\modules\quests\models\traits\StatItemAttributeLabelsTrait;

class StatItemForm extends Model
{
    use StatItemAttributeLabelsTrait;

    public $id;
    public $stat_id;
    public $task_id;
    public $question;
    public $task_answer;
    public $user_answer;
    public $is_correct;
    public $hint_used;
    public $hint_count;

    private $statItem;

    public function __construct(?StatItem $statItem = null, $config = [])
    {
        $this->statItem = $statItem;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->statItem) {
            return;
        }

        $this->id          = $this->statItem->id;
        $this->stat_id     = $this->statItem->stat_id;
        $this->task_id     = $this->statItem->task_id;
        $this->question    = $this->statItem->question;
        $this->task_answer = $this->statItem->task_answer;
        $this->user_answer = $this->statItem->user_answer;
        $this->is_correct  = $this->statItem->is_correct;
        $this->hint_used   = $this->statItem->hint_used;
        $this->hint_count  = $this->statItem->hint_count;
    }

    public function rules()
    {
        return [
            [['hint_used', 'is_correct', 'hint_count'], 'integer'],
            [['question', 'task_answer', 'user_answer'], 'integer'],
            [['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::class,
                'targetAttribute' => ['task_id' => 'id'],
            ],
            [['stat_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Stat::class,
                'targetAttribute' => ['stat_id' => 'id'],
            ],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->statItem) {
            return $this->statItem->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->statItem) {
            return false;
        }

        return true;
    }

    public function setStat($id)
    {
        $this->stat_id = $id;
    }

    public function setRefs($statId, $taskId)
    {
        $this->stat_id = $statId;
        $this->task_id = $taskId;
    }
}
