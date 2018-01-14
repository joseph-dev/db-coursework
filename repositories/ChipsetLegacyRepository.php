<?php

namespace app\repositories;

use app\models\Chipset;
use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;

class ChipsetLegacyRepository extends BaseLegacyRepository
{
    protected $tableName;

    /**
     * ManufacturerLegacyRepository constructor.
     */
    public function __construct()
    {
        $this->tableName = Chipset::tableName();
    }

    /**
     * @return mixed
     */
    protected function getModelInstance()
    {
        return new Chipset();
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

        $model = $this->getModelInstance();
        $model->setAttributes($data);
        $model->id = (int)$data['id'];

        return $model;
    }

    /**
     * @return ActiveRecord[]
     */
    public function all()
    {
        $data = Yii::$app->db->createCommand("SELECT id, name FROM {$this->tableName}")->queryAll();

        if (!$data) {
            return [];
        }

        $result = [];

        foreach ($data as $datum) {
            $model = $this->getModelInstance();
            $model->setAttributes($datum);
            $model->id = (int)$datum['id'];
            $result[] = $model;
        }

        return $result;
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

    /**
     * @param $model
     * @param $data
     * @return bool
     */
    public function createWith($model, $data)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {

            if (!$this->create($model)) {
                $transaction->rollBack();
                return false;
            }

            if (isset($data['sockets']) && is_array($data['sockets'])) {

                foreach ($data['sockets'] as $socket) {
                    Yii::$app->db->createCommand("INSERT INTO chipsets_x_sockets (chipset_id, socket_id) VALUES({$model->id}, {$socket})")->execute();
                }

            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @param $model
     * @param $data
     * @return bool
     */
    public function updateWith($model, $data)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {

            if (!$this->update($model)) {
                $transaction->rollBack();
                return false;
            }

            if (isset($data['sockets'])) {

                Yii::$app->db->createCommand("DELETE FROM chipsets_x_sockets WHERE chipset_id = {$model->id}")->execute();

                if (is_array($data['sockets'])) {

                    foreach ($data['sockets'] as $socket) {
                        Yii::$app->db->createCommand("INSERT INTO chipsets_x_sockets (chipset_id, socket_id) VALUES({$model->id}, {$socket})")->execute();
                    }

                }

            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @param $socket
     * @return mixed
     */
    public function findBySocket($socket)
    {
        $data = Yii::$app->db
            ->createCommand("
                SELECT {$this->tableName}.id, {$this->tableName}.name FROM {$this->tableName}
                JOIN chipsets_x_sockets ON chipsets_x_sockets.chipset_id = {$this->tableName}.id
                WHERE chipsets_x_sockets.socket_id = {$socket->id}
            ")->queryAll();

        if (!$data) {
            return [];
        }

        $result = [];

        foreach ($data as $datum) {
            $model = $this->getModelInstance();
            $model->setAttributes($datum);
            $model->id = (int)$datum['id'];
            $result[] = $model;
        }

        return $result;
    }
}