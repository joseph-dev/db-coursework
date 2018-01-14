<?php

namespace app\repositories;

use app\models\Chipset;
use Yii;
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
        return $socket->chipsets;
    }
}