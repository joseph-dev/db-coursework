<?php

namespace app\repositories;

use app\models\Motherboard;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class MotherboardModernRepository extends BaseModernRepository
{
    /**
     * @param $id
     * @return Motherboard
     */
    public function find($id)
    {
        return Motherboard::findOne($id);
    }

    /**
     * @return ActiveRecord[]
     */
    public function all()
    {
        return Motherboard::find()->all();
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
            'query'      => Motherboard::find(),
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