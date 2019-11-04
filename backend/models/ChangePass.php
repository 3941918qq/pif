<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Adminuser;

/**
 * Password reset request form
 */
class ChangePass extends Model
{
    public $pwd;
    public $newPwd;
    public $reNewPwd;
    public $uid;
    private  $_user;
    


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // 在这里定义验证规则
            [['pwd', 'newPwd','reNewPwd','uid'], 'required'],    
            ['newPwd', 'string', 'min' => 5],
            ['pwd', 'validatePassword'],
            ['newPwd', 'compare', 'compareAttribute' => 'pwd','operator' => '!=','message'=>'新密码不能和旧密码相同！'],
            ['reNewPwd', 'compare', 'compareAttribute' => 'newPwd','message'=>'两次输入的新密码不一致！'],
        ];
    }
    
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {         
        
        if (!$this->hasErrors()) {
            $user = $this->getUser();           
            if (!$user || !$user->validatePassword($this->pwd)) {
                $this->addError($attribute, '旧密码不正确.');
            }
        }
    }
    public  function attributeLabels() {
        return[
            'pwd'=>'旧密码',
            'newPwd'=>'新密码',
            'reNewPwd'=>'确认新密码'
        ];
    }
    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function change()
    {
//        var_dump($this->validate());die;
        if ($this->validate()) {
               $user = $this->_user;              
               $user->setPassword($this->newPwd);
               $user->removePasswordResetToken();
               return $user->save(false);
        }
        
        return false;
    }
    
    protected function getUser()
    {
        
        if ($this->_user === null) {            
            $this->_user = Adminuser::findOne($this->uid);
        }       
        return $this->_user;
    }
    
}


