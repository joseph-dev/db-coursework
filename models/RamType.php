<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ram_types".
 *
 * @property int $id
 * @property string $name
 *
 * @property Motherboards[] $motherboards
 */
class RamType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ram_types';
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
    public function getMotherboards()
    {
        return $this->hasMany(Motherboards::className(), ['ram_type_id' => 'id']);
    }
}
