<?php

namespace app\repositories;

use app\models\Manufacturer;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class ManufacturerModernRepository extends BaseModernRepository
{
    /**
     * @param $id
     * @return Manufacturer
     */
    public function find($id)
    {
        return Manufacturer::findOne($id);
    }

    /**
     * @return Manufacturer[]
     */
    public function all()
    {
        return Manufacturer::find()->all();
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
            'query'      => Manufacturer::find(),
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