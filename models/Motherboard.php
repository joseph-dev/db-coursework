<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "motherboards".
 *
 * @property int $id
 * @property string $name
 * @property int $manufacturer_id
 * @property int $form_factor_id
 * @property int $chipset_id
 * @property int $socket_id
 * @property int $ram_type_id
 * @property int $ram_slots
 * @property int $ram_max
 * @property int $ram_chanels
 * @property string $power_connector
 * @property string $audio
 * @property string $video
 * @property int $height
 * @property int $width
 *
 * @property ExternalPort[] $externalPorts
 * @property Slot[] $slots
 * @property StoragePort[] $storagePorts
 * @property Chipset $chipset
 * @property FormFactor $formFactor
 * @property Manufacturer $manufacturer
 * @property RamType $ramType
 * @property Socket $socket
 */
class Motherboard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'motherboards';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'name',
                    'manufacturer_id',
                    'form_factor_id',
                    'chipset_id',
                    'socket_id',
                    'ram_type_id',
                    'ram_slots',
                    'ram_max',
                    'ram_chanels',
                    'power_connector',
                    'audio',
                    'video',
                    'height',
                    'width'
                ],
                'required'
            ],
            [
                [
                    'manufacturer_id',
                    'form_factor_id',
                    'chipset_id',
                    'socket_id',
                    'ram_type_id',
                    'ram_slots',
                    'ram_max',
                    'ram_chanels',
                    'height',
                    'width'
                ],
                'integer'
            ],
            [['name', 'power_connector', 'audio', 'video'], 'string', 'max' => 255],
            [
                ['chipset_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Chipset::className(),
                'targetAttribute' => ['chipset_id' => 'id']
            ],
            [
                ['form_factor_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => FormFactor::className(),
                'targetAttribute' => ['form_factor_id' => 'id']
            ],
            [
                ['manufacturer_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Manufacturer::className(),
                'targetAttribute' => ['manufacturer_id' => 'id']
            ],
            [
                ['ram_type_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => RamType::className(),
                'targetAttribute' => ['ram_type_id' => 'id']
            ],
            [
                ['socket_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Socket::className(),
                'targetAttribute' => ['socket_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('app', 'ID'),
            'name'            => Yii::t('app', 'Name'),
            'manufacturer_id' => Yii::t('app', 'Manufacturer'),
            'form_factor_id'  => Yii::t('app', 'Form Factor'),
            'chipset_id'      => Yii::t('app', 'Chipset'),
            'socket_id'       => Yii::t('app', 'Socket'),
            'ram_type_id'     => Yii::t('app', 'Ram Type'),
            'ram_slots'       => Yii::t('app', 'Ram Slots'),
            'ram_max'         => Yii::t('app', 'Ram Max'),
            'ram_chanels'     => Yii::t('app', 'Ram Chanels'),
            'power_connector' => Yii::t('app', 'Power Connector'),
            'audio'           => Yii::t('app', 'Audio'),
            'video'           => Yii::t('app', 'Video'),
            'height'          => Yii::t('app', 'Height'),
            'width'           => Yii::t('app', 'Width'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExternalPorts()
    {
        return $this->hasMany(ExternalPort::className(),
            ['id' => 'external_port_id'])->viaTable('motherboadrs_x_external_ports', ['motherboard_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSlots()
    {
        return $this->hasMany(Slot::className(), ['id' => 'slot_id'])->viaTable('motherboadrs_x_slots',
            ['motherboard_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStoragePorts()
    {
        return $this->hasMany(StoragePort::className(),
            ['id' => 'storage_port_id'])->viaTable('motherboadrs_x_storage_ports', ['motherboard_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChipset()
    {
        return $this->hasOne(Chipset::className(), ['id' => 'chipset_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormFactor()
    {
        return $this->hasOne(FormFactor::className(), ['id' => 'form_factor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturer()
    {
        return $this->hasOne(Manufacturer::className(), ['id' => 'manufacturer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRamType()
    {
        return $this->hasOne(RamType::className(), ['id' => 'ram_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocket()
    {
        return $this->hasOne(Socket::className(), ['id' => 'socket_id']);
    }
}
