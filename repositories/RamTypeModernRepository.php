<?php

namespace app\repositories;

use app\models\RamType;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class RamTypeModernRepository extends BaseModernRepository
{
    /**
     * @param $id
     * @return RamType
     */
    public function find($id)
    {
        return RamType::findOne($id);
    }

    /**
     * @return ActiveRecord[]
     */
    public function all()
    {
        return RamType::find()->all();
    }

    /**
     * @param $model ActiveRecord
     * @return bool
     */
    public function create($model)
    {
        return $model->save(false);
    }

    /**
     * @param $model ActiveRecord
     * @return bool
     */
    public function update($model)
    {
        return $model->save(false);
    }

    /**
     * @param $model ActiveRecord
     * @return bool
     */
    public function delete($model)
    {
        return $model->delete();
    }

    /**
     * @return mixed
     */
    public function dataProvider()
    {
        return new ActiveDataProvider([
            'query'      => RamType::find(),
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
    }
}