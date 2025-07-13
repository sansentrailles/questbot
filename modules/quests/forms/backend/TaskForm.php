<?php

declare(strict_types=1);

namespace app\modules\quests\forms\backend;

use yii\base\Model;
use app\custom\files\BaseImageFile;
use app\modules\quests\models\Task;
use app\modules\quests\models\Quest;
use app\custom\traits\common\form\UploadFilesTrait;
use app\modules\quests\models\traits\TaskAttributeLabelsTrait;

class TaskForm extends Model
{
    use TaskAttributeLabelsTrait;
    use UploadFilesTrait;

    public $id;
    public $quest_id;
    public $is_visible;
    public $question;
    public $answer;
    public $type;
    public $place;
    public $address;
    public $longitude;
    public $latitude;
    public $message;
    public $place_show;
    public $image;
    public $imageFile;
    public $image_info;
    public $imageInfoFile;

    public $taskImage;
    public $taskImageInfo;

    private $task;

    public function __construct(?Task $task = null, $config = [])
    {
        $this->taskImage = new BaseImageFile(Task::BUCKET_NAME_IMAGE);
        $this->taskImageInfo = new BaseImageFile(Task::BUCKET_NAME_IMAGE_INFO);

        $this->task = $task;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->task) {
            return;
        }

        $this->id         = $this->task->id;
        $this->quest_id   = $this->task->quest_id;
        $this->question   = $this->task->question;
        $this->answer     = $this->task->answer;
        $this->type       = $this->task->type;
        $this->place      = $this->task->place;
        $this->address    = $this->task->address;
        $this->longitude  = $this->task->longitude;
        $this->latitude   = $this->task->latitude;
        $this->message    = $this->task->message;
        $this->image      = $this->task->image;
        $this->image_info = $this->task->image_info;
        $this->place_show = $this->task->place_show;
        $this->is_visible = $this->task->is_visible;
    }

    public function rules()
    {
        return [
            [['is_visible', 'place_show'], 'integer'],
            [['question', 'message', 'answer'], 'string'],
            [['place', 'address'], 'string'],
            [['question', 'type'], 'required', 'message' => 'Обязательно для заполнения'],
            [['type'], 'in', 'range' => array_keys(Task::getTypes())],
            [['quest_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Quest::class,
                'targetAttribute' => ['quest_id' => 'id'],
            ],
            [['longitude', 'latitude'], 'string', 'max' => 255],
            [['imageFile', 'imageInfoFile'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->task) {
            return $this->task->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->task) {
            return false;
        }

        return true;
    }

    public function getUploadOptions()
    {
        return [
            'imageFile' => [
                'image' => [
                    'transform' => [
                        $this->taskImage->save(),
                    ],
                ],
            ],
            'imageInfoFile' => [
                'image_info' => [
                    'transform' => [
                        $this->taskImageInfo->save(),
                    ],
                ],
            ],
        ];
    }

    public function getImagePath()
    {
        return $this->task->imagePath;
    }

    public function getImageInfoPath()
    {
        return $this->task->imageInfoPath;
    }

    public function setQuest($id)
    {
        $this->quest_id = $id;
    }
}
