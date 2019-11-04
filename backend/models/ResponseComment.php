<?php
namespace backend\models;
use common\models\Comment;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ResponseComment extends  \yii\base\Model{
    public $rep_id;
    public $unique_key;
    public $content;
    public function rules(){
        return [
            // 在这里定义验证规则
            [[ 'content','rep_id','unique_key'], 'required'],
        ];
    }
    public function response(){

        if ($this->validate()) {
             $comment=new Comment;
             $comment->unique_key=$this->unique_key;
             $comment->content=$this->content;
             $comment->type="rep";
             $comment->ctime=date("Y-m-d H:i:s",time());
             $comment->flag=1;
             $comment->rep_id=$this->rep_id;
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
            'rep_id'=>'回复的用户id',
            'unique_key'=>'产品识别码',
            'content'=>'内容',
        ];
    }
}
