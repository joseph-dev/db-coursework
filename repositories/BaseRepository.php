<?php

namespace app\repositories;

use yii\db\ActiveRecord;

abstract class BaseRepository
{

    /**
     * @param $id
     * @return ActiveRecord
     */
    public abstract function find($id);

    /**
     * @param $model
     * @return bool
     */
    public abstract function create($model);

    /**
     * @param $model
     * @return bool
     */
    public abstract function update($model);

    /**
     * @param $model
     * @return bool
     */
    public abstract function delete($model);

    /**
     * @return mixed
     */
    public abstract function dataProvider();

}