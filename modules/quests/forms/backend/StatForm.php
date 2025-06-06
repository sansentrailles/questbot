<?php

declare(strict_types=1);

namespace app\modules\quests\forms\backend;

use yii\base\Model;
use app\modules\quests\models\Stat;
use app\modules\quests\models\Quest;
use app\modules\quests\models\traits\StatAttributeLabelsTrait;

class StatForm extends Model
{
    use StatAttributeLabelsTrait;

    public $id;
    public $quest_id;
    public $user_id;
    public $start;
    public $finish;

    private $stat;

    public function __construct(?Stat $stat = null, $config = [])
    {
        $this->stat = $stat;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->stat) {
            return;
        }

        $this->id       = $this->stat->id;
        $this->quest_id = $this->stat->quest_id;
        $this->user_id  = $this->stat->user_id;
        $this->start    = $this->stat->start;
        $this->finish   = $this->stat->finish;
    }

    public function rules()
    {
        return [
            [['start', 'finish'], 'integer'],
            [['user_id'], 'integer'],
            [['quest_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Quest::class,
                'targetAttribute' => ['quest_id' => 'id'],
            ],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->stat) {
            return $this->stat->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->stat) {
            return false;
        }

        return true;
    }

    public function setQuest($id)
    {
        $this->quest_id = $id;
    }
}
