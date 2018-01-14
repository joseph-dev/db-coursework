<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chipsets".
 *
 * @property int $id
 * @property string $name
 *
 * @property ChipsetsXSockets[] $chipsetsXSockets
 * @property Sockets[] $sockets
 * @property Motherboards[] $motherboards
 */
class Chipset extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chipsets';
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
    public function getChipsetsXSockets()
    {
        return $this->hasMany(ChipsetsXSockets::className(), ['chipset_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSockets()
    {
        return $this->hasMany(Sockets::className(), ['id' => 'socket_id'])->viaTable('chipsets_x_sockets', ['chipset_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMotherboards()
    {
        return $this->hasMany(Motherboards::className(), ['chipset_id' => 'id']);
    }
}
