<?php

declare(strict_types=1);

namespace app\modules\quests\models;

use yii\db\ActiveRecord;
use app\custom\files\BaseImageFile;
use yii\behaviors\TimestampBehavior;
use app\custom\traits\models\VisibilityTrait;
use app\custom\interfaces\annotations\Fileable;
use app\modules\quests\forms\backend\QuestForm as Form;
use app\modules\quests\models\traits\QuestAttributeLabelsTrait;

/**
 * This is the model class for table "quests".
 *
 * @property int $id
 * @property string $title
 * @property string $code
 * @property string $image
 * @property string $desc
 * @property int $date
 * @property int $limit
 * @property int $created_at
 * @property int $updated_at
 */
class Quest extends ActiveRecord implements Fileable
{
    use QuestAttributeLabelsTrait;
    use VisibilityTrait;

    public const STATUS_INVISIBLE = 0;
    public const STATUS_VISIBLE = 1;

    public const BUCKET_NAME_IMAGE = 'questImage';

    private $imageFile;

    public function __construct($config = [])
    {
        $this->imageFile = new BaseImageFile(self::BUCKET_NAME_IMAGE);

        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'quests';
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

        $model->title      = $form->title;
        $model->code       = $form->code;
        $model->desc       = $form->desc;
        $model->date       = $form->date;
        $model->image      = $form->image;
        $model->limit      = $form->limit;
        $model->is_visible = $form->is_visible;

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->title      = $form->title;
        $this->code       = $form->code;
        $this->desc       = $form->desc;
        $this->date       = $form->date;
        $this->image      = $form->image;
        $this->limit      = $form->limit;
        $this->is_visible = $form->is_visible;
    }


    public function getImageFiles()
    {
        $files = [];
        if ($this->image) {
            $files[] = [
                'bucket' => $this->imageFile->getBucket(),
                'file' => $this->image,
            ];
        }
        return $files;
    }


    public function getNestedFiles(): array
    {
        $files = [];
        $files = array_merge($files, $this->getImageFiles());
        return $files;
    }

    public function getImagePath()
    {
        if ($this->image) {
            return $this->imageFile->getPath($this->image);
        }

        return null;
    }

    public function getImageFullPath()
    {
        if ($this->image) {
            return \Yii::getAlias("@webroot")."/".$this->imagePath;
        }

        return null;
    }

    public function getTasks()
    {
        return $this->hasMany(Task::class, ['quest_id' => 'id']);
    }

    public function getVisibleTasks()
    {
        return $this->getTasks()
            ->andWhere(['is_visible' => Task::STATUS_VISIBLE])
            ->orderBy('ord');
    }
}
