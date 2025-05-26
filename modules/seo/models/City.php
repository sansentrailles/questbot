<?php

declare(strict_types=1);

namespace app\modules\seo\models;

use app\custom\interfaces\annotations\Sortable;
use app\custom\traits\models\SortableTrait;
use app\custom\traits\models\VisibilityTrait;
use app\modules\seo\forms\backend\CityForm as Form;
use app\modules\seo\models\traits\CityAttributeLabelsTrait;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "seo_cities".
 *
 * @property int $id
 * @property string $title
 * @property string $is_default
 * @property string $city
 * @property string $masks
 * @property int $created_at
 * @property int $updated_at
 */
class City extends \yii\db\ActiveRecord implements Sortable
{
    use CityAttributeLabelsTrait;
    use SortableTrait;
    use VisibilityTrait;

    const STATUS_INVISIBLE = 0;
    const STATUS_VISIBLE = 1;

    public const STATE_DEFAULT = 1;
    public const STATE_NOT_DEFAULT = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo_cities';
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
        $model->code       = $form->code;
        $model->masks      = $form->masks;
        $model->is_visible = $form->is_visible;
        $model->is_default = $form->is_default;

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->title      = $form->title;
        $this->code       = $form->code;
        $this->masks      = $form->masks;
        $this->is_visible = $form->is_visible;
        $this->is_default = $form->is_default;
    }

    public function getMaskList()
    {
        $masks = [];
        $arrMasks = json_decode($this->masks);
        foreach ($arrMasks as $mask) {
            $masks[] = [
                'title' => $mask->title,
                'form' => $mask->form,
            ];
        }

        return $masks;
    }

    public function toggleDefault()
    {
        return $this->is_default = $this->is_default ? self::STATE_NOT_DEFAULT : self::STATE_DEFAULT;
    }

    public static function dropDefaultStates(): void
    {
        self::updateAll(['is_default' => self::STATE_NOT_DEFAULT], ['=', 'is_default', self::STATE_DEFAULT]);
    }

    public function fields() {
        return [
            'id',
            'title',
            'code',
            'is_default',
        ];
    }
}
