<?php

declare(strict_types=1);

namespace app\modules\quests\forms\backend;

use yii\base\Model;
use app\custom\files\BaseImageFile;
use app\modules\quests\models\Hint;
use app\modules\quests\models\Task;
use app\modules\quests\models\Quest;
use app\custom\traits\common\form\UploadFilesTrait;
use app\modules\quests\models\traits\HintAttributeLabelsTrait;

class HintForm extends Model
{
    use HintAttributeLabelsTrait;
    use UploadFilesTrait;

    public $id;
    public $task_id;
    public $is_visible;
    public $text;
    public $image;
    public $imageFile;

    public $hintImage;

    private $hint;

    public function __construct(?Hint $hint = null, $config = [])
    {
        $this->hintImage = new BaseImageFile(Hint::BUCKET_NAME_IMAGE);

        $this->hint = $hint;
        parent::__construct($config);
    }



    public function init(): void
    {
        if (!$this->hint) {
            return;
        }

        $this->id         = $this->hint->id;
        $this->task_id    = $this->hint->task_id;
        $this->text       = $this->hint->text;
        $this->image      = $this->hint->image;
        $this->is_visible = $this->hint->is_visible;
    }

    public function rules()
    {
        return [
            [['is_visible'], 'integer'],
            [['text'], 'string'],
            [['text'], 'required', 'message' => 'Обязательно для заполнения'],
            [['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::class,
                'targetAttribute' => ['task_id' => 'id'],
            ],
            [['imageFile'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->hint) {
            return $this->hint->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->hint) {
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
                        $this->hintImage->save(),
                    ],
                ],
            ],
        ];
    }

    public function getImagePath()
    {
        return $this->hint->imagePath;
    }

    public function setTask($id)
    {
        $this->task_id = $id;
    }
}
