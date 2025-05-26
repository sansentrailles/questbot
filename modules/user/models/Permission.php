<?php

declare(strict_types=1);

namespace app\modules\user\models;

use app\modules\user\forms\backend\PermissionForm as Form;
use app\modules\user\models\traits\PermissionAttributeLabelsTrait;
use yii\behaviors\TimestampBehavior;
use yii\rbac\Item;

/**
 * This is the model class for table "auth_item".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $type
 * @property int $created_at
 * @property int $updated_at
 */
class Permission extends \yii\db\ActiveRecord
{
    use PermissionAttributeLabelsTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function add(Form $form)
    {
        $model = new self();

        $model->name        = $form->name;
        $model->description = $form->description;
        $model->type        = Item::TYPE_PERMISSION;

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->description      = $form->description;
    }
}
