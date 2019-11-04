<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use Yii;
/**
 * Signup form
 */
class LoginForm extends Model
{
    public $username;
    public $code;
    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
//            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '该号码已经被注册！'],
            ['username', 'match','pattern'=>'/^[1][345789][0-9]{9}$/', 'message' => '请输入正确格式的手机号！' ],
            ['code', 'required','message'=>'请输入6位验证码！'],
            ['code','match','pattern'=>'/^[0-9]{6}$/','message'=>'验证码是6位数字！'],
            ['code', 'validateCode'],
        ];
    }
    public function attributeLabels() {
        return[
            'username'=>'电话',
            'code'=>'验证码'
        ];
    }
    //验证code是否过期以及是否正确
    public function validateCode($attribute, $params){
         $session = Yii::$app->session;
         if($this->$attribute!=$session['code']['num']){
             $this->addError($attribute, '验证码不正确！');
             return false;
         }
         if(!isset($session['code']) || $session['code']['expire_time'] < time()){
              $this->addError($attribute, '验证码已经过期，请重新获取！');
              return false;
         }
         
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function Login($recommendUserId){
        if (!$this->validate()) {          
             $data['status']='fail';
             return $data;
        }
        
        //验证手机号是否注册过，注册过直接跳转home，否则入库并跳转到完善资料页面
        $user = $this->getUser();
        
        if(!$user){
            $user = new User();
            $user->last_login_time=time();
            $user->last_login_ip=$_SERVER["REMOTE_ADDR"];
            $user->username = $this->username;           
            $user->generateAuthKey();
            $user->save(false);
            $data['status']='needComplete';
            $data['uid']=$user->id;
            if($recommendUserId!=null){
               $data['recommend']=$recommendUserId;   
            }
        }else{
            //记录最后登录时间和IP
            $user->last_login_time=time();
            $user->last_login_ip=$_SERVER["REMOTE_ADDR"];
            $user->save(false);
            //姓名没填写直接去完善资料
            $data['uid']=$user->id;
            if(!$user->name){                
                 $data['status']='needComplete';
            }else {
                Yii::$app->user->login($this->getUser(), 3600 * 24 * 30 );
                $data['status']='alreadyComplete';
            }           
        }   
        return $data;

    }
    
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser(){
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }
       
        return $this->_user;
    }
    
    /**
     * save.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function changetel(){
        
        if (!$this->validate()) {          
            return  null;
        }
        return true;
    }
}
