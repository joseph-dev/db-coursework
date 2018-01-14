<?php

namespace app\repositories;

use app\models\Slot;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class SlotModernRepository extends BaseModernRepository
{
    /**
     * @param $id
     * @return Slot
     */
    public function find($id)
    {
        return Slot::findOne($id);
    }

    /**
     * @return ActiveRecord[]
     */
    public function all()
    {
        return Slot::find()->all();
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
            'query'      => Slot::find(),
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