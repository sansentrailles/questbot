<?php

declare(strict_types=1);

namespace app\modules\settings\forms\backend\search;

use app\modules\settings\models\Setting;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SettingSearch represents the model behind the search form about `app\modules\settings\models\Setting`.
 */
class SettingSearch extends Setting
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'group_id'], 'integer'],
            [['key', 'title', 'desc', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     * @param mixed $withContent
     *
     * @return ActiveDataProvider
     */
    public function search($params, $withContent = false)
    {
        $query = Setting::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['title' => SORT_ASC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'       => $this->id,
            'group_id' => $this->group_id,
            'key'      => $this->key,
            'type_id'  => $this->type_id,
            'title'    => $this->title,
        ]);

        $query->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }

    public function forGroup($groupId)
    {
        $this->group_id = $groupId;

        return $this;
    }
}
