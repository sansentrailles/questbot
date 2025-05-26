<?php

declare(strict_types=1);

namespace app\modules\seo\models;

use app\modules\seo\forms\backend\SeoForm as Form;
use app\modules\seo\models\traits\SeoAttributeLabelsTrait;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "seo".
 *
 * @property int $id
 * @property int $ref_id
 * @property string $section
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $text
 * @property int $created_at
 * @property int $updated_at
 */
class Seo extends \yii\db\ActiveRecord
{
    use SeoAttributeLabelsTrait;

    private $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo';
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

        $model->ref_id      = $form->ref_id;
        $model->section     = $form->section;
        $model->title       = $form->title;
        $model->keywords    = $form->keywords;
        $model->description = $form->description;
        $model->text        = $form->text;

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->ref_id      = $form->ref_id;
        $this->section     = $form->section;
        $this->title       = $form->title;
        $this->keywords    = $form->keywords;
        $this->description = $form->description;
        $this->text        = $form->text;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function fields()
    {
        return [
            'title' => static fn ($model) => $model->title ?? '',
            'keywords' => static fn ($model) => $model->keywords ?? '',
            'description' => static fn ($model) => $model->description ?? '',
            'image' => static fn ($model) => $model->image ?? '',
        ];
    }
}
