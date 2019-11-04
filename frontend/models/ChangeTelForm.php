<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use Yii;
/**
 * Signup form
 */
class ChangeTelForm extends Model
{
    public $username;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '该号码已经被注册！'],
            ['username', 'match','pattern'=>'/^[1][345789][0-9]{9}$/', 'message' => '请输入正确格式的手机号！' ],
        ];
    }
    public function attributeLabels() {
        return[
            'username'=>'电话',
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save($id){
        
        if (!$this->validate() || !isset($id)) {          
            return  null;
        }
        $model=User::findOne($id);
        $model->username=$this->username;
        return ($model->save(false)) ? true :  false;
      
    }
    
}


