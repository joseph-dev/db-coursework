<?php

namespace app\repositories;

use app\models\Socket;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class SocketModernRepository extends BaseModernRepository
{
    /**
     * @param $id
     * @return Socket
     */
    public function find($id)
    {
        return Socket::findOne($id);
    }

    /**
     * @return Socket[]
     */
    public function all()
    {
        return Socket::find()->all();
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
            'query'      => Socket::find(),
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

            if (isset($data['chipsets']) && is_array($data['chipsets'])) {

                foreach ($data['chipsets'] as $chipset) {
                    Yii::$app->db->createCommand("INSERT INTO chipsets_x_sockets (chipset_id, socket_id) VALUES({$chipset}, {$model->id})")->execute();
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

            if (isset($data['chipsets'])) {

                Yii::$app->db->createCommand("DELETE FROM chipsets_x_sockets WHERE socket_id = {$model->id}")->execute();

                if (is_array($data['chipsets'])) {

                    foreach ($data['chipsets'] as $chipset) {
                        Yii::$app->db->createCommand("INSERT INTO chipsets_x_sockets (chipset_id, socket_id) VALUES({$chipset}, {$model->id})")->execute();
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
     * @param $chipset
     * @return mixed
     */
    public function findByChipset($chipset)
    {
        return $chipset->sockets;
    }
}