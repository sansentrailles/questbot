<?php

declare(strict_types=1);

namespace app\modules\quests\forms\backend;

use yii\base\Model;
use app\modules\quests\models\Task;
use app\modules\quests\models\Quest;
use app\modules\quests\models\UserProgress;

class UserProgressForm extends Model
{
    public $id;
    public $user_id;
    public $quest_id;
    public $current_task_id;
    public $is_completed;

    private $userProgress;

    public function __construct(?UserProgress $userProgress = null, $config = [])
    {
        $this->userProgress = $userProgress;
        parent::__construct($config);
    }



    public function init(): void
    {
        if (!$this->userProgress) {
            return;
        }

        $this->id              = $this->userProgress->id;
        $this->quest_id        = $this->userProgress->quest_id;
        $this->current_task_id = $this->userProgress->current_task_id;
        $this->user_id         = $this->userProgress->user_id;
        $this->is_completed    = $this->userProgress->is_completed;
    }

    public function rules()
    {
        return [
            [['is_completed'], 'in', 'range' => [UserProgress::STATE_COMPLETED, UserProgress::STATE_NOT_COMPLETED] ],
            [['user_id'], 'integer'],
            [['quest_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Quest::class,
                'targetAttribute' => ['quest_id' => 'id'],
            ],
            [['current_task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::class,
                'targetAttribute' => ['current_task_id' => 'id'],
            ],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->userProgress) {
            return $this->userProgress->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->userProgress) {
            return false;
        }

        return true;
    }
}
