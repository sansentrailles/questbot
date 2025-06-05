<?php

declare(strict_types=1);

namespace app\modules\quests\models;

use yii\db\ActiveRecord;
use app\custom\files\BaseImageFile;
use app\custom\interfaces\annotations\Fileable;
use yii\behaviors\TimestampBehavior;
use app\custom\traits\models\SortableTrait;
use app\custom\traits\models\VisibilityTrait;
use app\custom\interfaces\annotations\Sortable;
use app\modules\quests\forms\backend\TaskForm as Form;
use app\modules\quests\models\traits\TaskAttributeLabelsTrait;

/**
 * This is the model class for table "{{%quest_tasks}}".
 * @property int $id
 * @property int $quest_id
 * @property string $question
 * @property string $image
 * @property string $answer
 * @property int $type
 * @property string $place
 * @property string $address
 * @property string $longitude
 * @property string $latitude
 * @property string $message
 * @property int $is_visible
 * @property int $created_at
 * @property int $updated_at
 */
class Task extends ActiveRecord implements Sortable, Fileable
{
    use TaskAttributeLabelsTrait;
    use SortableTrait;
    use VisibilityTrait;

    public const STATUS_INVISIBLE = 0;
    public const STATUS_VISIBLE = 1;

    public const TYPE_INPUT = 1;
    public const TYPE_CHOICE = 2;

    public const BUCKET_NAME_IMAGE = 'taskImage';

    private $imageFile;

    public function __construct($config = [])
    {
        $this->imageFile = new BaseImageFile(self::BUCKET_NAME_IMAGE);

        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'quest_tasks';
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

        $model->quest_id   = $form->quest_id;
        $model->address    = $form->address;
        $model->question   = $form->question;
        $model->image      = $form->image;
        $model->answer     = $form->answer;
        $model->type       = $form->type;
        $model->place      = $form->place;
        $model->longitude  = $form->longitude;
        $model->latitude   = $form->latitude;
        $model->message    = $form->message;
        $model->is_visible = $form->is_visible;

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->quest_id   = $form->quest_id;
        $this->address    = $form->address;
        $this->question   = $form->question;
        $this->image      = $form->image;
        $this->answer     = $form->answer;
        $this->type       = $form->type;
        $this->place      = $form->place;
        $this->longitude  = $form->longitude;
        $this->latitude   = $form->latitude;
        $this->message    = $form->message;
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

    public static function getTypes()
    {
        return [
            self::TYPE_INPUT => 'Ввод ответа',
            self::TYPE_CHOICE => 'Выбор варианта ответа',
        ];
    }

    public function getQuest()
    {
        return $this->hasOne(Quest::class, ['id' => 'quest_id']);
    }

    public function getImageFullPath()
    {
        if ($this->image) {
            return \Yii::getAlias("@webroot")."/".$this->imagePath;
        }

        return null;
    }

    public function getAnswers()
    {
        return $this->hasMany(Answer::class, ['task_id' => 'id'])
            ->orderBy(['ord' => SORT_ASC]);
    }

    public function getHints()
    {
        return $this->hasMany(Answer::class, ['task_id' => 'id']);
    }

    public function getVisibleHints()
    {
        return $this->getHints()
            ->andWhere(['is_visible' => Hint::STATUS_VISIBLE])
            ->orderBy(['ord' => SORT_ASC]);
    }
}
