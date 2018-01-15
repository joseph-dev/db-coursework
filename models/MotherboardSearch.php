<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\VarDumper;

/**
 *
 */
class MotherboardSearch extends Motherboard
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider|SqlDataProvider
     */
    public function search($params)
    {
        $dataProvider = null;

        if (APP_MODE === 'legacy') {
            $dataProvider = $this->legacySearch($params);
        } else {
            $dataProvider = $this->modernSearch($params);
        }

        return $dataProvider;
    }

    /**
     * @param $params
     * @return SqlDataProvider
     */
    protected function legacySearch($params)
    {
        $this->load($params);
        $tableName = Motherboard::tableName();

        $count = Yii::$app->db->createCommand("SELECT COUNT(*) FROM {$tableName}")->queryScalar();
        $query = "SELECT * FROM {$tableName}";

        if ($this->validate() && $this->name) {
            $count = Yii::$app->db->createCommand("SELECT COUNT(*) FROM {$tableName} WHERE name LIKE '%{$this->name}%'")->queryScalar();
            $query = "SELECT * FROM {$tableName} WHERE name LIKE '%{$this->name}%'";
        }

        return new SqlDataProvider([
            'sql'        => $query,
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort'       => [
                'attributes'   => [
                    'id',
                    'name'
                ],
                'defaultOrder' => [
                    'name' => SORT_ASC
                ]
            ],
            'key'        => 'id'
        ]);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    protected function modernSearch($params)
    {
        $query = Motherboard::find();

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort'       => [
                'attributes'   => [
                    'id',
                    'name'
                ],
                'defaultOrder' => [
                    'name' => SORT_ASC
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
