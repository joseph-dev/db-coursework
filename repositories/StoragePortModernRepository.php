<?php

namespace app\repositories;

use app\models\StoragePort;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class StoragePortModernRepository extends BaseModernRepository
{
    /**
     * @param $id
     * @return StoragePort
     */
    public function find($id)
    {
        return StoragePort::findOne($id);
    }

    /**
     * @return ActiveRecord[]
     */
    public function all()
    {
        return StoragePort::find()->all();
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
            'query'      => StoragePort::find(),
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