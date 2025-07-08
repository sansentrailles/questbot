<?php

declare(strict_types=1);

namespace app\modules\quests\models;

use yii\db\ActiveRecord;
use app\modules\quests\forms\backend\StatForm as Form;
use app\modules\quests\models\traits\StatAttributeLabelsTrait;

/**
 * This is the model class for table "{{%quest_stats}}".
 * @property int $id
 * @property int $quest_id
 * @property int $user_id
 * @property int $start
 * @property int $finish
 */
class Stat extends ActiveRecord
{
    use StatAttributeLabelsTrait;

    public static function tableName()
    {
        return 'quest_stats';
    }

    public static function add(Form $form)
    {
        $model = new self();

        $model->quest_id = $form->quest_id;
        $model->user_id  = $form->user_id;
        $model->start    = $form->start;
        $model->finish   = $form->finish;

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->quest_id = $form->quest_id;
        $this->user_id  = $form->user_id;
        $this->start    = $form->start;
        $this->finish   = $form->finish;
    }

    public function getQuest()
    {
        return $this->hasOne(Quest::class, ['id' => 'quest_id']);
    }
}
