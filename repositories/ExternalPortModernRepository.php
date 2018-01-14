<?php

namespace app\repositories;

use app\models\ExternalPort;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class ExternalPortModernRepository extends BaseModernRepository
{
    /**
     * @param $id
     * @return ExternalPort
     */
    public function find($id)
    {
        return ExternalPort::findOne($id);
    }

    /**
     * @return ActiveRecord[]
     */
    public function all()
    {
        return ExternalPort::find()->all();
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
            'query'      => ExternalPort::find(),
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