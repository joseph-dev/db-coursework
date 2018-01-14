<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sockets".
 *
 * @property int $id
 * @property string $name
 *
 * @property Chipset[] $chipsets
 * @property Motherboard[] $motherboards
 */
class Socket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sockets';
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
            'id'       => Yii::t('app', 'ID'),
            'name'     => Yii::t('app', 'Name'),
            'chipsets' => Yii::t('app', 'Chipsets'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChipsets()
    {
        return $this->hasMany(Chipset::className(), ['id' => 'chipset_id'])->viaTable('chipsets_x_sockets',
            ['socket_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMotherboards()
    {
        return $this->hasMany(Motherboard::className(), ['socket_id' => 'id']);
    }
}
