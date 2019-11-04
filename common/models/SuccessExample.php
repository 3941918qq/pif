<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "success_example".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $content 内容
 * @property string $img_url 图片链接
 * @property string $ctime
 * @property string $utime
 * @property int $car_id 车辆类别ID
 * @property int $code_id 业务类别ID
 * @property string $isvip_view 非vip是否可见，0不 1可
 * @property int $page_view 浏览量
 * @property int $givelike_total 点赞 
 * @property string $unique_key 唯一识别号 
 * @property int $userid
 *
 * @property CodeList $code
 */
class SuccessExample extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'success_example';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'isvip_view'], 'string'],
            [['ctime', 'utime'], 'safe'],
            [['car_id', 'code_id', 'page_view', 'givelike_total', 'userid', 'view_level'], 'integer'],
            [['img_url', 'unique_key'], 'string', 'max' => 255],
            ['title', 'string', 'max' => 30],
            [['title','content'],'required'],
            [['code_id'], 'exist', 'skipOnError' => true, 'targetClass' => CodeList::className(), 'targetAttribute' => ['code_id' => 'id']],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => CodeList::className(), 'targetAttribute' => ['car_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'img_url' => '图片地址',
            'ctime' => '增加时间',
            'utime' => '更新时间',
            'car_id' => '车辆类别',
            'code_id' => '业务类别',
            'isvip_view' => '非VIP是否可见',
            'page_view' => '浏览量',
            'givelike_total' => '点赞数量',
            'unique_key'=>'产品识别码',
            'userid' => '增加人',
            'view_level' => '用户可视级别',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCode()
    {
        return $this->hasOne(CodeList::className(), ['id' => 'code_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCar()
    {
        return $this->hasOne(CodeList::className(), ['id' => 'car_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminuser()
    {
        return $this->hasOne(Adminuser::className(), ['id' => 'userid']);
    }
    

    public function beforeSave($insert) {
        preg_match('<img.*?src="(.*?)">',$this->content,$match);
        if(isset($match[1])){
            $this->img_url=$match[1];
        }       
        if(parent::beforeSave($insert)){            
            if($this->isNewRecord){
               //字段               
                $this->unique_key=md5(time().mt_rand(1,1000));
                $this->ctime=date('Y-m-d H:i:s',time());              
            }else{
                $this->utime=date('Y-m-d H:i:s',time());
            }
            return true;
        }else return false;
    }
}
