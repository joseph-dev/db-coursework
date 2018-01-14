<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "external_ports".
 *
 * @property int $id
 * @property string $name
 *
 * @property MotherboadrsXExternalPorts[] $motherboadrsXExternalPorts
 * @property Motherboards[] $motherboards
 */
class ExternalPort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'external_ports';
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
    public function getMotherboadrsXExternalPorts()
    {
        return $this->hasMany(MotherboadrsXExternalPorts::className(), ['external_port_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMotherboards()
    {
        return $this->hasMany(Motherboards::className(), ['id' => 'motherboard_id'])->viaTable('motherboadrs_x_external_ports', ['external_port_id' => 'id']);
    }
}
