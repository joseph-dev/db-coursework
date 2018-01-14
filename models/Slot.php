<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slots".
 *
 * @property int $id
 * @property string $name
 *
 * @property Motherboard[] $motherboards
 */
class Slot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slots';
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
        return $this->hasMany(Motherboard::className(), ['id' => 'motherboard_id'])->viaTable('motherboadrs_x_slots',
            ['slot_id' => 'id']);
    }
}
