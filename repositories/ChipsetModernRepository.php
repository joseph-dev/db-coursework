<?php

namespace app\repositories;

use app\models\Chipset;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class ChipsetModernRepository extends BaseModernRepository
{
    /**
     * @param $id
     * @return Chipset
     */
    public function find($id)
    {
        return Chipset::findOne($id);
    }

    /**
     * @return ActiveRecord[]
     */
    public function all()
    {
        return Chipset::find()->all();
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
            'query'      => Chipset::find(),
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