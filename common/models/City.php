<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $name
 * @property int $pro_id
 * @property string $created
 *
 * @property Province $pro
 * @property County[] $counties
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pro_id'], 'integer'],
            [['created'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['pro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['pro_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'pro_id' => 'Pro ID',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPro()
    {
        return $this->hasOne(Province::className(), ['id' => 'pro_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCounties()
    {
        return $this->hasMany(County::className(), ['city_id' => 'id']);
    }
}
