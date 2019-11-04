<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $u_id 用户id
 * @property int $p_id 文档id
 * @property string $content 评论
 * @property string $type 评论是提交者还是回复者
 * @property string $ctime
 * @property string $flag
 *
 * @property User $u
 * @property DataManage $p
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['u_id','rep_id'], 'integer'],
            [['content', 'type', 'flag', 'unique_key'], 'string'],
            [['ctime'], 'safe'],
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
            'u_id' => '用户ID',
            'unique_key' => '产品识别码',
            'content' => '内容',
            'type' => '评论类型',
            'ctime' => '创建时间',
            'flag' => '是否审核',
            'rep_id'=>'回复的用户ID'
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
