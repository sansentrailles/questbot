<?php

declare(strict_types=1);

namespace app\modules\settings\forms\backend\search;

use app\modules\settings\models\SettingValue;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SettingValueSearch represents the model behind the search form about `app\modules\settings\models\SettingValue`.
 */
class SettingValueSearch extends SettingValue
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'setting_id'], 'integer'],
            [['value'], 'safe'],
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
        $query = SettingValue::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['order' => SORT_ASC],
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
            'value' => $this->value,
            'setting_id' => $this->setting_id,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }

    public function forSetting($settingId)
    {
        $this->setting_id = $settingId;

        return $this;
    }
}
