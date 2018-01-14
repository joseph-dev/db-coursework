<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "storage_ports".
 *
 * @property int $id
 * @property string $name
 *
 * @property MotherboadrsXStoragePorts[] $motherboadrsXStoragePorts
 * @property Motherboards[] $motherboards
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
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMotherboadrsXStoragePorts()
    {
        return $this->hasMany(MotherboadrsXStoragePorts::className(), ['storage_port_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMotherboards()
    {
        return $this->hasMany(Motherboards::className(), ['id' => 'motherboard_id'])->viaTable('motherboadrs_x_storage_ports', ['storage_port_id' => 'id']);
    }
}
