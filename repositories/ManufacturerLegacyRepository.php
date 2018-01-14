<?php

namespace app\repositories;

use Yii;
use app\models\Manufacturer;
use yii\base\Model;
use yii\data\SqlDataProvider;

class ManufacturerLegacyRepository extends BaseRepository
{
    protected $tableName;

    /**
     * ManufacturerLegacyRepository constructor.
     */
    public function __construct()
    {
        $this->tableName = Manufacturer::tableName();
    }

    /**
     * @param $id
     * @return Model
     */
    public function find($id)
    {
        $data = Yii::$app->db->createCommand("SELECT id, name FROM {$this->tableName} WHERE id = {$id}")->queryOne();

        if (!$data) {
            return null;
        }

        $model = new Manufacturer();
        $model->setAttributes($data);
        $model->id = (int)$data['id'];

        return $model;
    }

    /**
     * @param $model Model
     * @return bool
     */
    public function create($model)
    {
        try {
            Yii::$app->db->createCommand("INSERT INTO {$this->tableName} (name) VALUES('{$model->name}')")->execute();
            $model->id = (int)Yii::$app->db->getLastInsertID();
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }

    /**
     * @param $model Model
     * @return bool
     */
    public function update($model)
    {
        try {
            Yii::$app->db->createCommand("UPDATE {$this->tableName} SET name='{$model->name}' WHERE id = {$model->id}")->execute();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $model
     * @return bool
     */
    public function delete($model)
    {
        return Yii::$app->db->createCommand("DELETE FROM {$this->tableName} WHERE id = {$model->id}")->execute();
    }

    /**
     * @return mixed
     */
    public function dataProvider()
    {
        $count = Yii::$app->db->createCommand("SELECT COUNT(*) FROM {$this->tableName}")->queryScalar();

        return new SqlDataProvider([
            'sql'        => "SELECT * FROM {$this->tableName}",
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
}