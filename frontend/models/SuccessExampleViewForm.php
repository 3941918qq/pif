<?php
namespace frontend\models;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Yii;
use yii\base\Model;
use common\models\SuccessExampleSearch;
use common\models\SuccessExample;
use common\models\Comment;
use common\models\GiveLike;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;


class SuccessExampleViewForm extends SuccessExample{
    //方法一：分页获取案例数据
    public function getInfo($params=null,$couser=null){
        $query = SuccessExample::find()->select(['success_example.*', 'IF( com.c IS NULL ,0,com.c) as comment_total'])->asArray();
        $count = $query->count();
        // 使用总数来创建一个分页对象
        $pagination = new Pagination(['totalCount' => $count,'defaultPageSize' => 6,]);
        if(isset($params['code']) &&isset($params['type'])){
            switch ($params['type']){
                case 1:
                  $query->andFilterWhere(['car_id' => $params['code'],]);
                  break;  
                case 2:
                  $query->andFilterWhere(['code_id' => $params['code'],]);
                  break;
                default:
            }
        }else if(isset($params['search'])){
            $query->andFilterWhere(['like', 'title', $params['search']]);
        }
        $query->join('left join','(SELECT comment.unique_key,count(*) as c from comment group by comment.unique_key) com','success_example.unique_key = com.unique_key');  
        $posts= $query->offset($pagination->offset) ->limit($pagination->limit)->all();                  
        $len=count($posts);
        for($k=1;$k<$len;$k++){
            for($j=0;$j<$len-$k;$j++){
                $posts[$j]['total']=$posts[$j]['page_view']+$posts[$j]['givelike_total']+$posts[$j]['comment_total'];
                $posts[$j+1]['total']=$posts[$j+1]['page_view']+$posts[$j+1]['givelike_total']+$posts[$j+1]['comment_total'];
                if($posts[$j]['total']<$posts[$j+1]['total']){
                    $temp =$posts[$j+1];
                    $posts[$j+1]=$posts[$j];
                    $posts[$j]=$temp;
                }
            }
        }
        $data['posts']=$posts;
        $data['pagination']=$pagination;
        return $data;
    }
    //方法二：上拉加载案例数据
    public function getRecords($page,$params=null){
        $query = SuccessExample::find()->select(['success_example.*', 'IF( com.c IS NULL ,0,com.c) as comment_total'])->asArray();
        if(isset($params['code']) &&isset($params['type'])){
            switch ($params['type']){
                case 1:
                  $query->andFilterWhere(['car_id' => $params['code'],]);
                  break;  
                case 2:
                  $query->andFilterWhere(['code_id' => $params['code'],]);
                  break;
                default:
            }
        }else if(isset($params['search'])){
            $query->andFilterWhere(['like', 'title', $params['search']]);
        }
        $query->join('left join','(SELECT comment.unique_key,count(*) as c from comment group by comment.unique_key) com','success_example.unique_key = com.unique_key');  
        $num=6;
        $start=($page-1)*$num;
        $posts= $query->offset($start) ->limit($num)->all();
        $len=count($posts);
        for($k=1;$k<$len;$k++){
            for($j=0;$j<$len-$k;$j++){
                $posts[$j]['total']=$posts[$j]['page_view']+$posts[$j]['givelike_total']+$posts[$j]['comment_total'];
                $posts[$j+1]['total']=$posts[$j+1]['page_view']+$posts[$j+1]['givelike_total']+$posts[$j+1]['comment_total'];
                if($posts[$j]['total']<$posts[$j+1]['total']){
                    $temp =$posts[$j+1];
                    $posts[$j+1]=$posts[$j];
                    $posts[$j]=$temp;
                }
            }
        }
        return $posts;
    }
    public function getDetailInfo($params,$uid=null){
        if(!$params){
            return null;
        }
        $model=SuccessExample::findOne($params);
        if($model){
            //返回当前查找数据对象模型
            $data['model']=$model;
            //返回当前数据对应者的收藏情况
            $isCollect=GiveLike::find()->where(['unique_key'=>$model->unique_key,'u_id'=>$uid])->one();
            if($isCollect){
                $data['isCollect']=1;
            }else $data['isCollect']=0;
            $allComment=Comment::find()
                    ->select('comment.*,u.img_url,u.username')
                    ->where(['comment.unique_key'=>$model->unique_key,'flag'=>1,'type'=>'com'])
                    ->join('left join','user u','u.id=comment.u_id')
                    ->orderBy('ctime DESC')
                    ->asArray()
                    ->all();
            
            if($allComment){
                foreach($allComment as $k=>$v){
                    $allComment[$k]['adminRep']=Comment::find()
                    ->select('comment.*,u.img_url,u.username')
                    ->where(['comment.rep_id'=>$v['id'],'comment.unique_key'=>$v['unique_key'],'flag'=>1,'type'=>'rep'])
                    ->join('left join','user u','u.id=comment.u_id')
                    ->orderBy('ctime DESC')
                    ->asArray()
                    ->all();
                }
                //返回当前数据对象对应的评论模型
                $data['comment']=$allComment;
            }else $data['comment']=null;
        }else $data['model']=null;    
        return $data;
    }
    
    public function subComment($post){
        if(!$post){
            return false;
        }
        $modelComment=new Comment;
        $modelComment->u_id=$post['uid'];
        $modelComment->unique_key=$post['uniquekey'];
        $modelComment->content=$post['content'];
        $modelComment->type='com';
        $modelComment->ctime=date("Y-m-d H:i:s",time());
        $modelComment->flag=0;
        return $modelComment->save(false) ? $modelComment->id :-1;
    }
    
    public function toggleCollect($post){
        if(!$post){
            return false;
        }

        if($post['flag']>0){
            $modelGivelike=new GiveLike;
            $modelGivelike->u_id=$post['uid'];
            $modelGivelike->unique_key=$post['uniquekey'];
            $modelGivelike->ctime=date("Y-m-d H:i:s",time());
            $res=$modelGivelike->save(false); 
            $datamanage = SuccessExample::find()->where(['unique_key' => $post['uniquekey']])->one();
            $resu=$datamanage->updateCounters(['givelike_total'=>1]);
            return $resu;
            
        }else{
            $modelGivelike=GiveLike::find()->where(['unique_key'=>$post['uniquekey']])->one();
            $modelGivelike->delete();
            $datamanage = SuccessExample::find()->where(['unique_key' => $post['uniquekey']])->one();
            $resu=$datamanage->updateCounters(['givelike_total'=>-1]);
            return $resu;
        }
        
        
    }
}