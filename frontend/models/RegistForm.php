<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\imagine\Image;
/**
 * Signup form
 */
class RegistForm extends Model
{
    public $name;
    public $sex;
    public $company;
    public $birthday;
    
    public $img_url;
    public $area;
    public $address;
    public $email;
    public $imageFile;
    


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'company', 'address', 'area','sex'], 'safe'],
            [['name','company'] ,'trim'],
            [['name','company','sex'], 'required'],          
            ['name', 'string', 'min' => 2, 'max' => 20],
            ['company', 'string', 'min' => 2, 'max' => 50],
            ['birthday', 'default', 'value' => '1980-01-01'],
            [['img_url'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true],
            ['email', 'email','message'=>'邮箱格式不正确'],
        ];
    }
    public function attributeLabels(){
        return[
            'name'=>'姓名',
            'sex'=>'性别',
            'company'=>'所属单位',
            'birthday'=>'出生日期',
            'img_url'=>'头像',
            'area'=>'所在地区',
            'address'=>'通讯地址',
            'email'=>'邮箱'
        ];
    }
    
    //实现上传
    public function upload()
    {
         
        if ($this->validate()) {
            $filepath='uploads/header/';
            if (!is_dir($filepath)){
                mkdir($filepath,0777,true);
            }
            $basepath=$filepath. md5($this->imageFile->baseName.time()). '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($basepath);
            Image::thumbnail($basepath,180,180)->save(Yii::getAlias($basepath), ['quality' => 100]);
            $this->img_url=yii::$app->params['frontend.url'].'/'.$basepath;
            return true;
        } else {
            return false;
        }
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save($id,$type=null,$recommendId=null)
    {
        if (!$this->validate()) {
                return null;
        }
        //如果有推荐人，给推荐人加分
        if($recommendId!=null){
            $recommendId=  base64_decode($recommendId);
            $recommender=User::findOne($recommendId);
            if($recommender){
                $recommender->updateCounters(['score'=>10]);
                $recommender->save(false);
            }
        }      
        $user=User::findOne($id);  
        if($type=="change"){
            if($this->imageFile){
                $user->img_url = $this->img_url;
            }
            if($this->area){
                $user->area = $this->area;
            }
            if($this->address){
                $user->address = $this->address;
            }
             if($this->email){
                $user->email = $this->email;
            }
        }
        $user->name = $this->name;
        $user->sex = $this->sex;
        if($this->sex==1 && $type==null){
            $user->img_url=yii::$app->params['frontend.url'].'/img/women.png';
        }else if($this->sex==0 && $type==null){
            $user->img_url=yii::$app->params['frontend.url'].'/img/men.png';
        }
        $user->company = $this->company;
        $user->birthday = $this->birthday;
        if($user->save(false)){
            Yii::$app->user->login($user, 3600 * 24 * 30 );
            return $user->id;
        }else return null;
//      return $user->save(false) ?  $user->id: null;
    }
}


