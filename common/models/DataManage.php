<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "data_manage".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $url
 * @property string $content 文本
 * @property string $type 区别文本还是视频
 * @property string $is_top 是否在课程展示
 * @property int $code_id 车辆类别id
 * @property string $ctime 创建时间
 * @property string $utime 更新时间
 * @property int $page_view 浏览量
 * @property string $isvip_view 非vip是否可见，0不 1可
 *
 * @property Collect[] $collects
 * @property Comment[] $comments
 */
class DataManage extends \yii\db\ActiveRecord
{
    //用来存储视频文件对象
    public $videoFile;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_manage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'type', 'isvip_view','is_top'], 'string'],
            [['car_id', 'code_id', 'page_view', 'givelike_total','view_level'], 'integer'],
            [['ctime', 'utime'], 'safe'],
            [['url','unique_key'], 'string', 'max' => 255],
            ['title', 'string', 'max' => 30],
            [['videoFile'], 'file', 'skipOnEmpty' => true],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => CodeList::className(), 'targetAttribute' => ['car_id' => 'id']],
            [['code_id'], 'exist', 'skipOnError' => true, 'targetClass' => CodeList::className(), 'targetAttribute' => ['code_id' => 'id']],
        ];
    }
    //实现上传
    public function upload()
    {
         
        if ($this->validate()) {
            if(!isset($this->videoFile)){
                return true;
            }
            $filepath='uploads/video/';
            if (!is_dir($filepath)){
                mkdir($filepath,0777,true);
            }
            $basepath=$filepath. md5($this->videoFile->baseName.time()). '.' . $this->videoFile->extension;
            $this->videoFile->saveAs($basepath);
            $this->url=yii::$app->params['backend.url'].'/'.$basepath;
            return true;
        } else {
            return false;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'url' => '地址',
            'content' => '简介',
            'type' => '类型',
            'is_top'=>'是否在课程展示',
            'car_id' => '车辆类别',
            'code_id' => '业务类别',
            'ctime' => '增加时间',
            'utime' => '更新时间',
            'page_view' => '浏览量',
            'isvip_view' => '非VIP是否可见',
            'unique_key'=>'产品识别码',
            'view_level' => '用户可视级别',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollects()
    {
        return $this->hasMany(Collect::className(), ['p_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['p_id' => 'id']);
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
    public function getCode()
    {
        return $this->hasOne(CodeList::className(), ['id' => 'code_id']);
    }
    //钩子
     public function beforeSave($insert) {
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
