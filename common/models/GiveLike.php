<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "give_like".
 *
 * @property int $id 用户id
 * @property int $u_id
 * @property string $unique_key 产品识别码
 * @property string $ctime
 *
 * @property User $u
 */
class GiveLike extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'give_like';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['u_id'], 'integer'],
            [['ctime'], 'safe'],
            [['unique_key'], 'string', 'max' => 255],
            [['u_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['u_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'u_id' => 'U ID',
            'unique_key' => 'Unique Key',
            'ctime' => 'Ctime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(User::className(), ['id' => 'u_id']);
    }
}
