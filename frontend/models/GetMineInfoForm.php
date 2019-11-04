<?php
namespace frontend\models;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Yii;
use yii\base\Model;
use common\models\DataManageSearch;
use common\models\DataManage;
use common\models\SuccessExample;
use common\models\Comment;
use common\models\User;
use common\models\GiveLike;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;


class GetMineInfoForm extends DataManage{
   
    //获取评论/点赞/分享/历史
    public  function getAll($uid=null,$arrHistoryUnique=null){
        //获取当前用户的所有评论
        //我的评论
        $query=Comment::find()->select('comment.*,u.img_url header,u.username,s.title,s.img_url,s.givelike_total,s.page_view,s.id cid')
                ->join('LEFT JOIN','user u','u.id=comment.u_id')
                ->join('LEFT JOIN','success_example s','s.unique_key=comment.unique_key')
                ->where(['u_id'=>$uid])
                ->orderBy('ctime DESC');
        $count=$query->count();
        $comPagination = new Pagination(['totalCount' => $count,'defaultPageSize' => 15]);
        $modelComment = $query->offset($comPagination->offset)->limit($comPagination->limit)->asArray()->all();
        if($modelComment){
            foreach($modelComment  as  $key=>$v){
                 if(!$v['title']){                   
                        $modelDatamanage=  DataManage::find()->where('unique_key=:unique_key')->addParams([':unique_key'=>$v['unique_key']])->one();
                        if(!$modelDatamanage) continue;
                        $modelComment[$key]['title']=$modelDatamanage->title; 
                        $modelComment[$key]['url']=$modelDatamanage->url;
                        $modelComment[$key]['givelike_total']=$modelDatamanage->givelike_total;
                        $modelComment[$key]['page_view']=$modelDatamanage->page_view;
                        $modelComment[$key]['poster']=$this->pregRep($modelDatamanage->content);
                        $modelComment[$key]['cid']=$modelDatamanage->id;
                 }
            }
             
        }else $modelComment=[];
        $data['comment']=$modelComment;
        $data['ComPagination']=$comPagination;

        //我的点赞
        $query1=GiveLike::find()->select('give_like.*,u.img_url header,u.username,s.title,s.img_url,s.givelike_total,s.page_view,s.id cid')
                ->join('LEFT JOIN','user u','u.id=give_like.u_id')
                ->join('LEFT JOIN','success_example s','s.unique_key=give_like.unique_key')
                ->where(['u_id'=>$uid])
                ->orderBy('ctime DESC');
        $count1=$query->count();
        $givePagination = new Pagination(['totalCount' => $count1,'defaultPageSize' => 15]);
        $modelGive = $query1->offset($givePagination->offset)->limit($givePagination->limit)->asArray()->all();
      
        if($modelGive){
            foreach($modelGive  as  $key=>$v){
                 if(!$v['title']){                   
                        $modelDatamanage=  DataManage::find()->where('unique_key=:unique_key')->addParams([':unique_key'=>$v['unique_key']])->one();
                        if(!$modelDatamanage) continue;
                        $modelGive[$key]['title']=$modelDatamanage->title; 
                        $modelGive[$key]['url']=$modelDatamanage->url;
                        $modelGive[$key]['givelike_total']=$modelDatamanage->givelike_total;
                        $modelGive[$key]['page_view']=$modelDatamanage->page_view;
                        $modelGive[$key]['poster']=$this->pregRep($modelDatamanage->content);
                        $modelGive[$key]['cid']=$modelDatamanage->id;
                   ;
                 }
            }
             
        }else $modelGive=[];
        $data['givelike']=$modelGive;
        $data['GivePagination']=$givePagination;
        //浏览历史
         $arr=[];
        if(isset($arrHistoryUnique) && !empty($arrHistoryUnique)){          
            foreach($arrHistoryUnique as $k=>$uniqueKey){
                $modelHistory= DataManage::find()->where(['unique_key'=>$uniqueKey])->asArray()->one(); 
                if(!$modelHistory){
                   $modelHistory = SuccessExample::find()->where(['unique_key'=>$uniqueKey])->asArray()->one(); 
                   
                }
                $modelHistory['poster']=$this->pregRep($modelHistory['content']);
                $arr[$k]=$modelHistory;              
            }
        }
        $data['history']=$arr;
        return $data;
    }

    function pregRep($content){
            preg_match('<img.*?src="(.*?)">',$content,$match);
            if($match){
                return $data=$match[1];
            }else return $data="";
    }

    
    function qrcode($uid){
        $user=User::findOne($uid);
        $value = yii::$app->params['frontend.url'].'/index/login?unique='.base64_encode($user->id); //二维码内容 
        $data['qrcode_value']=$value;
        if(empty($user->person_qrcode)){
            require_once Yii::getAlias('@frontend').'/assets/phpqrcode/phpqrcode.php';           
            $dir='uploads/qrcode/';
            if(!file_exists($dir)){
                mkdir($dir);
            }
            $filename=$dir.base64_encode($user->id).'.png';
            $errorCorrectionLevel = 'M';//容错级别   
            $matrixPointSize = 10;//生成图片大小 
            \QRcode::png($value,$filename,$errorCorrectionLevel,$matrixPointSize,2);
            $logo=$user->img_url;//logo图片
            $QR = $filename;//已经生成的原始二维码图
            if ($logo !== FALSE) {   
                $QR = imagecreatefromstring(file_get_contents($QR));   
                $logo = imagecreatefromstring(file_get_contents($logo));   
                $QR_width = imagesx($QR);//二维码图片宽度   
                $QR_height = imagesy($QR);//二维码图片高度   
                $logo_width = imagesx($logo);//logo图片宽度   
                $logo_height = imagesy($logo);//logo图片高度   
                $logo_qr_width = $QR_width / 5;   
                $scale = $logo_width/$logo_qr_width;   
                $logo_qr_height = $logo_height/$scale;   
                $from_width = ($QR_width - $logo_qr_width) / 2;   
                //重新组合图片并调整大小   
                imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,   
                $logo_qr_height, $logo_width, $logo_height);   
            }
            if(imagepng($QR, $filename)){
                $url=yii::$app->params['frontend.url'].'/'.$filename;
                $user->person_qrcode=$url;
                $user->save(false);
                $data['qrcode_url']=$url;                              
            };
         }else  $data['qrcode_url']=$user->person_qrcode;
         return $data;
    }
}