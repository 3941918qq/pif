<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "college".
 *
 * @property int $id
 * @property string $name
 * @property string $area
 */
class College extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'college';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'area'], 'required'],
            [['name', 'area'], 'string', 'max' => 50],
            [['name'], 'unique'],
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
            'area' => 'Area',
        ];
    }
}
