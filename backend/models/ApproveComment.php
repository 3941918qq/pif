<?php
namespace backend\models;
use common\models\Comment;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ApproveComment extends  \yii\base\Model{
    public $id;
    public $flag;
    public function rules(){
        return [
            // 在这里定义验证规则
            [[ 'flag','id'], 'required'],
//            ['flag', 'validateRole'],
        ];
    }
    
//    public function validateRole($attribute, $params){
//        if (!$this->hasErrors()) {            
//            if($this->role_id==0 && $this->ispass==1){
//                $this->addError($attribute, '请指定角色后再审核.');
//            }else if($this->role_id!=0 && $this->ispass==0){
//                $this->addError($attribute, '请将状态变更为已审核.');
//            }
//            
//        }
//    }
    public function approve(){
        if ($this->validate()) {
             $comment=Comment::findOne($this->id);
             $comment->flag=$this->flag;
             return ($comment->save(false)) ? true : false;            
         }else{
            $error=$this->ErrorInfo();       
            echo "<script>alert('".$error."');window.location='/comment/index';</script>"; 
            return false;
         }
    }
    public function ErrorInfo(){
        $tmp_earr     = $this->getFirstErrors();
        foreach( $this->activeAttributes() as $ati ) {
            if( isset( $tmp_earr[$ati] ) && !empty( $tmp_earr[$ati] ) ){
                return $tmp_earr[$ati]; 
            }              
        }       
    }
    public function attributeLabels(){
        return[
            'id'=>'id',
            'flag'=>'状态'
        ];
    }
}
