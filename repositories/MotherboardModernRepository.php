<?php

namespace app\repositories;

use app\models\Motherboard;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

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

            if (isset($data['slots'])) {

                foreach ($data['slots'] as $slot => $quantity) {
                    Yii::$app->db->createCommand("INSERT INTO motherboards_x_slots (motherboard_id, slot_id, quantity) VALUES({$model->id}, {$slot}, {$quantity})")->execute();
                }

            }

            if (isset($data['storagePorts'])) {

                foreach ($data['storagePorts'] as $port => $quantity) {
                    Yii::$app->db->createCommand("INSERT INTO motherboards_x_storage_ports (motherboard_id, storage_port_id, quantity) VALUES({$model->id}, {$port}, {$quantity})")->execute();
                }

            }

            if (isset($data['externalPorts'])) {

                foreach ($data['externalPorts'] as $port => $quantity) {
                    Yii::$app->db->createCommand("INSERT INTO motherboards_x_external_ports (motherboard_id, external_port_id, quantity) VALUES({$model->id}, {$port}, {$quantity})")->execute();
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

            if (isset($data['slots'])) {

                Yii::$app->db->createCommand("DELETE FROM motherboards_x_slots WHERE motherboard_id = {$model->id}")->execute();

                foreach ($data['slots'] as $slot => $quantity) {
                    Yii::$app->db->createCommand("INSERT INTO motherboards_x_slots (motherboard_id, slot_id, quantity) VALUES({$model->id}, {$slot}, {$quantity})")->execute();
                }

            }

            if (isset($data['storagePorts'])) {

                Yii::$app->db->createCommand("DELETE FROM motherboards_x_storage_ports WHERE motherboard_id = {$model->id}")->execute();

                foreach ($data['storagePorts'] as $port => $quantity) {
                    Yii::$app->db->createCommand("INSERT INTO motherboards_x_storage_ports (motherboard_id, storage_port_id, quantity) VALUES({$model->id}, {$port}, {$quantity})")->execute();
                }

            }

            if (isset($data['externalPorts'])) {

                Yii::$app->db->createCommand("DELETE FROM motherboards_x_external_ports WHERE motherboard_id = {$model->id}")->execute();

                foreach ($data['externalPorts'] as $port => $quantity) {
                    Yii::$app->db->createCommand("INSERT INTO motherboards_x_external_ports (motherboard_id, external_port_id, quantity) VALUES({$model->id}, {$port}, {$quantity})")->execute();
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
     * @return array
     */
    public function getSlotQuantitiesByMotherboard($model)
    {
        $rows = Yii::$app->db->createCommand("SELECT * FROM motherboards_x_slots WHERE motherboard_id = {$model->id}")->queryAll();
        return ArrayHelper::map($rows, 'slot_id', 'quantity');
    }

    /**
     * @param $model
     * @return array
     */
    public function getStoragePortQuantitiesByMotherboard($model)
    {
        $rows = Yii::$app->db->createCommand("SELECT * FROM motherboards_x_storage_ports WHERE motherboard_id = {$model->id}")->queryAll();
        return ArrayHelper::map($rows, 'storage_port_id', 'quantity');
    }

    /**
     * @param $model
     * @return array
     */
    public function getExternalPortQuantitiesByMotherboard($model)
    {
        $rows = Yii::$app->db->createCommand("SELECT * FROM motherboards_x_external_ports WHERE motherboard_id = {$model->id}")->queryAll();
        return ArrayHelper::map($rows, 'external_port_id', 'quantity');
    }

    /**
     * @param $model
     * @return mixed
     */
    public function findSlotsWithQuantitiesByMotherboard($model)
    {
        $rows = Yii::$app->db->createCommand("
            SELECT slots.name, motherboards_x_slots.quantity FROM slots 
            JOIN motherboards_x_slots ON motherboards_x_slots.slot_id = slots.id
            WHERE motherboards_x_slots.motherboard_id = {$model->id}
        ")->queryAll();

        return $rows;
    }

    /**
     * @param $model
     * @return mixed
     */
    public function findStoragePortsWithQuantitiesByMotherboard($model)
    {
        $rows = Yii::$app->db->createCommand("
            SELECT storage_ports.name, motherboards_x_storage_ports.quantity FROM storage_ports 
            JOIN motherboards_x_storage_ports ON motherboards_x_storage_ports.storage_port_id = storage_ports.id
            WHERE motherboards_x_storage_ports.motherboard_id = {$model->id}
        ")->queryAll();

        return $rows;
    }

    /**
     * @param $model
     * @return mixed
     */
    public function findExternalPortsWithQuantitiesByMotherboard($model)
    {
        $rows = Yii::$app->db->createCommand("
            SELECT external_ports.name, motherboards_x_external_ports.quantity FROM external_ports 
            JOIN motherboards_x_external_ports ON motherboards_x_external_ports.external_port_id = external_ports.id
            WHERE motherboards_x_external_ports.motherboard_id = {$model->id}
        ")->queryAll();

        return $rows;
    }
}