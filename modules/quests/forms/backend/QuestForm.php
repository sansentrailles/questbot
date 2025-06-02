<?php

declare(strict_types=1);

namespace app\modules\quests\forms\backend;

use app\custom\files\BaseImageFile;
use app\custom\files\converter\ConverterPresets;
use app\custom\traits\common\form\UploadFilesTrait;
use app\modules\quests\models\Quest;
use app\modules\quests\models\traits\QuestAttributeLabelsTrait;
use yii\base\Model;
use yii\behaviors\SluggableBehavior;

class QuestForm extends Model
{
    use QuestAttributeLabelsTrait;
    use UploadFilesTrait;

    public $id;
    public $title;
    public $code;
    public $desc;
    public $date;
    public $limit;
    public $is_visible;
    public $image;
    public $imageFile;

    public $questImage;


    private $quest;

    public function __construct(?Quest $quest = null, $config = [])
    {
        $this->questImage = new BaseImageFile(Quest::BUCKET_NAME_IMAGE);

        $this->quest = $quest;
        parent::__construct($config);
    }



    public function init(): void
    {
        if (!$this->quest) {
            return;
        }

        $this->id         = $this->quest->id;
        $this->title      = $this->quest->title;
        $this->code       = $this->quest->code;
        $this->desc       = $this->quest->desc;
        $this->limit      = $this->quest->limit;
        $this->date       = $this->quest->date;
        $this->image      = $this->quest->image;
        $this->is_visible = $this->quest->is_visible;
    }

    public function rules()
    {
        return [
            [['is_visible'], 'integer'],
            [['title', 'code'], 'string', 'max' => 255],
            [['desc'], 'string'],
            [['title'], 'required', 'message' => 'Введите название'],
            [['code'], 'unique', 'targetClass' => Quest::class, 'filter' => function ($query): void {
                if ($this->id) {
                    $query->andWhere('id <> :id', [':id' => $this->id]);
                }
            }],
            [['date'], 'string'],
            [['limit'], 'integer'],
            [['imageFile'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->quest) {
            return $this->quest->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->quest) {
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
                        $this->questImage->save(),
                    ],
                ],
            ],
        ];
    }

    public function getImagePath()
    {
        return $this->quest->imagePath;
    }
}
