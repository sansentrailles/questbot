<?php

declare(strict_types=1);

namespace app\modules\user\forms\backend\search;

use app\modules\user\Module;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;

/**
 * RoleSearch represents the model behind the search form.
 */
class RoleSearch extends Model
{
    public $id;
    public $name;
    public $description;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('common', 'ROLE_NAME'),
            'description' => Module::t('common', 'ROLE_DESCRIPTION'),
        ];
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
        $auth = Yii::$app->authManager;
        $data = $auth->getRoles();

        return new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['name'],
            ],
        ]);
    }
}
