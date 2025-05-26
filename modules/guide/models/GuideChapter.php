<?php

declare(strict_types=1);

namespace app\modules\guide\models;

use app\modules\guide\forms\backend\GuideChapterForm as Form;
use app\modules\guide\models\traits\GuideChapterAttributeLabelsTrait;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "guide_chapter".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $is_visible
 * @property int $ord
 * @property int $created_at
 * @property int $updated_at
 */
class GuideChapter extends \yii\db\ActiveRecord
{
    use GuideChapterAttributeLabelsTrait;

    public const STATUS_INVISIBLE = 0;
    public const STATUS_VISIBLE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'guide_chapter';
    }

    /**
     * {@inheritdoc}
     */
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
        $model->text       = $form->text;
        $model->is_visible = $form->is_visible;

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->title      = $form->title;
        $this->text       = $form->text;
        $this->is_visible = $form->is_visible;
    }

    public function setOrder(int $order): void
    {
        $this->ord = $order;
    }

    public function toggleVisible()
    {
        return $this->is_visible = !$this->is_visible;
    }
}
