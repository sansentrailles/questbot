<?php

declare(strict_types=1);

namespace app\modules\quests\forms\backend\search;

use app\modules\quests\models\Task as SearchModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class TaskSearch extends SearchModel
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['question', 'place', 'address'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SearchModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['finish' => SORT_DESC],
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
            'id' => $this->id,
            'quest_id' => $this->quest_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }

    public function forQuest($id)
    {
        $this->quest_id = $id;
        return $this;
    }
}
