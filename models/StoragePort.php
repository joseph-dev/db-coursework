<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "storage_ports".
 *
 * @property int $id
 * @property string $name
 *
 * @property Motherboard[] $motherboards
 */
class StoragePort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'storage_ports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'   => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMotherboards()
    {
        return $this->hasMany(Motherboard::className(),
            ['id' => 'motherboard_id'])->viaTable('motherboadrs_x_storage_ports', ['storage_port_id' => 'id']);
    }
}
