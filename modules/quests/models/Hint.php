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
use app\modules\quests\forms\backend\HintForm as Form;
use app\modules\quests\models\traits\HintAttributeLabelsTrait;

/**
 * This is the model class for table "{{%quest_task_hints}}".
 * @property int $id
 * @property int $task_id
 * @property string $text
 * @property string $image
 * @property int $is_visible
 * @property int $created_at
 * @property int $updated_at
 */
class Hint extends ActiveRecord implements Sortable, Fileable
{
    use HintAttributeLabelsTrait;
    use SortableTrait;
    use VisibilityTrait;

    public const STATUS_INVISIBLE = 0;
    public const STATUS_VISIBLE = 1;

    public const BUCKET_NAME_IMAGE = 'taskHintImage';

    private $imageFile;

    public function __construct($config = [])
    {
        $this->imageFile = new BaseImageFile(self::BUCKET_NAME_IMAGE);

        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'quest_task_hints';
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

        $model->task_id    = $form->task_id;
        $model->text       = $form->text;
        $model->image      = $form->image;
        $model->is_visible = $form->is_visible;

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->task_id    = $form->task_id;
        $this->text       = $form->text;
        $this->image      = $form->image;
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

    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    public function getImageFullPath()
    {
        if ($this->image) {
            return \Yii::getAlias("@webroot")."/".$this->imagePath;
        }

        return null;
    }
}
