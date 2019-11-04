<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "adminuser".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $role
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $last_login_time
 * @property string $last_login_ip
 */
class Adminuser extends \yii\db\ActiveRecord  implements IdentityInterface
{
    public $password;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adminuser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['username', 'auth_key', 'password_hash', 'created_at', 'updated_at','password'], 'required'],
//            [['role', 'status', 'created_at', 'updated_at'], 'integer'],
//            [['last_login_time'], 'safe'],
//            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
//            [['auth_key'], 'string', 'max' => 32],
//            [['last_login_ip','password'], 'string', 'max' => 50],
            [['username','password'], 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '该用户已经被占用.'],
            [['username'],'string','max'=>30],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'role' => '角色',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登陆IP',
            'password'=>'密码'
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
       
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function add()
    {
        
        if (!$this->validate()) {
            return null;
        }
        
        $user = new Adminuser();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);      
        $user->generateAuthKey();
        return $user->save(false) ? $user->id : null;
    }
    
    public function change($id){
        if (!$this->validate()) {
            return null;
        }
        $model=Adminuser::findOne($id);
        $model->username = $this->username;
        $model->email = $this->email;
        $model->setPassword($this->password);      
        $model->removePasswordResetToken();
        return $model->save(false) ? $model->id : null;
    }
    
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)){            
            if($this->isNewRecord){
               //字段               
                $this->created_at=time();                            
            }else{
                $this->updated_at=time();
            }
            return true;
        }else return false;
    }
    public static function getModelError($model) {
        $errors = $model->getErrors();    //得到所有的错误信息
        if(!is_array($errors)) return '';
        $firstError = array_shift($errors);
        if(!is_array($firstError)) return '';
        return array_shift($firstError);
    }
}
