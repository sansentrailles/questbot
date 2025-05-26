<?php

declare(strict_types=1);

namespace app\modules\main\forms\backend\search;

use app\modules\lang\interfaces\lang\ILang;
use app\modules\main\models\Employee;
use app\modules\main\models\EmployeeLang;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * EmployeeSearch represents the model behind the search form main `app\modules\main\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    public $name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_visible'], 'integer'],
            [['name'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params, ILang $language)
    {
        $query = Employee::find();
        $query->distinct()->joinWith(['employeeLang' => static function (\yii\db\ActiveQuery $query) use ($language): void {
            $query->where(['lang_id' => $language->getId()]);
        }]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['ord' => SORT_ASC],
            ],
        ]);

        $dataProvider->sort->attributes['name'] = [
            'asc' => [EmployeeLang::tableName() . '.value' => SORT_ASC],
            'desc' => [EmployeeLang::tableName() . '.value' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_visible' => $this->is_visible,
        ]);

        $query->andFilterWhere(['like', EmployeeLang::tableName() . '.value', $this->name]);

        return $dataProvider;
    }
}
