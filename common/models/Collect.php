<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "collect".
 *
 * @property int $id
 * @property int $u_id 用户id
 * @property int $p_id 对应文本id
 * @property string $ctime
 * @property string $flag
 *
 * @property User $u
 * @property DataManage $p
 */
class Collect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collect';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['u_id', 'p_id'], 'integer'],
            [['ctime'], 'safe'],
            [['flag'], 'string'],
            [['u_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['u_id' => 'id']],
            [['p_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataManage::className(), 'targetAttribute' => ['p_id' => 'id']],
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
            'p_id' => 'P ID',
            'ctime' => 'Ctime',
            'flag' => 'Flag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(User::className(), ['id' => 'u_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getP()
    {
        return $this->hasOne(DataManage::className(), ['id' => 'p_id']);
    }
}
