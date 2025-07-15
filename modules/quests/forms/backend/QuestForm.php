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
    public $announce;
    public $code;
    public $desc;
    public $text_final;
    public $help;
    public $date;
    public $limit;
    public $is_visible;
    public $is_active;
    public $image;
    public $imageFile;
    public $image_final;
    public $imageFinalFile;

    public $questImage;
    public $questImageFinal;

    private $quest;

    public function __construct(?Quest $quest = null, $config = [])
    {
        $this->questImage = new BaseImageFile(Quest::BUCKET_NAME_IMAGE);
        $this->questImageFinal = new BaseImageFile(Quest::BUCKET_NAME_IMAGE_FINAL);

        $this->quest = $quest;
        parent::__construct($config);
    }



    public function init(): void
    {
        if (!$this->quest) {
            return;
        }

        $this->id          = $this->quest->id;
        $this->title       = $this->quest->title;
        $this->announce    = $this->quest->announce;
        $this->code        = $this->quest->code;
        $this->desc        = $this->quest->desc;
        $this->help        = $this->quest->help;
        $this->limit       = $this->quest->limit;
        $this->date        = $this->quest->date;
        $this->image       = $this->quest->image;
        $this->image_final = $this->quest->image_final;
        $this->text_final  = $this->quest->text_final;
        $this->is_visible  = $this->quest->is_visible;
        $this->is_active   = $this->quest->is_active;
    }

    public function rules()
    {
        return [
            [['is_visible', 'is_active'], 'integer'],
            [['title', 'code'], 'string', 'max' => 255],
            [['desc', 'help', 'text_final', 'announce'], 'string'],
            [['title'], 'required', 'message' => 'Введите название'],
            [['code'], 'unique', 'targetClass' => Quest::class, 'filter' => function ($query): void {
                if ($this->id) {
                    $query->andWhere('id <> :id', [':id' => $this->id]);
                }
            }],
            [['date'], 'string'],
            [['limit'], 'integer'],
            [['imageFile', 'imageFinalFile'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
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
            'imageFinalFile' => [
                'image_final' => [
                    'transform' => [
                        $this->questImageFinal->save(),
                    ],
                ],
            ],
        ];
    }

    public function getImagePath()
    {
        return $this->quest->imagePath;
    }

    public function getImageFinalPath()
    {
        return $this->quest->imageFinalPath;
    }
}
