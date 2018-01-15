<?php

namespace app\repositories;

use app\models\Motherboard;
use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;

class MotherboardLegacyRepository extends BaseLegacyRepository
{
    protected $tableName;

    /**
     * ManufacturerLegacyRepository constructor.
     */
    public function __construct()
    {
        $this->tableName = Motherboard::tableName();
    }

    /**
     * @return mixed
     */
    protected function getModelInstance()
    {
        return new Motherboard();
    }

    /**
     * @param $id
     * @return Model
     */
    public function find($id)
    {
        $data = Yii::$app->db->createCommand("SELECT * FROM {$this->tableName} WHERE id = {$id}")->queryOne();

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
        $data = Yii::$app->db->createCommand("SELECT * FROM {$this->tableName}")->queryAll();

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
            Yii::$app->db->createCommand("
                INSERT INTO {$this->tableName} 
                (name, manufacturer_id, form_factor_id, chipset_id, socket_id, ram_type_id, ram_slots, ram_max, ram_chanels, power_connector, audio, video, height, width) 
                VALUES('{$model->name}', '{$model->manufacturer_id}', '{$model->form_factor_id}', '{$model->chipset_id}', '{$model->socket_id}', '{$model->ram_type_id}', '{$model->ram_slots}', '{$model->ram_max}', '{$model->ram_chanels}', '{$model->power_connector}', '{$model->audio}', '{$model->video}', '{$model->height}', '{$model->width}')
            ")->execute();
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
            Yii::$app->db->createCommand("
                UPDATE {$this->tableName} 
                SET 
                    name = '{$model->name}',
                    manufacturer_id = '{$model->manufacturer_id}',
                    form_factor_id = '{$model->form_factor_id}',
                    chipset_id = '{$model->chipset_id}',
                    socket_id = '{$model->socket_id}',
                    ram_type_id = '{$model->ram_type_id}',
                    ram_slots = '{$model->ram_slots}',
                    ram_max = '{$model->ram_max}',
                    ram_chanels = '{$model->ram_chanels}',
                    power_connector = '{$model->power_connector}',
                    audio = '{$model->audio}',
                    video = '{$model->video}',
                    height = '{$model->height}',
                    width = '{$model->width}'
                WHERE id = {$model->id}
            ")->execute();
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