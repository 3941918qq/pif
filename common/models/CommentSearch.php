<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comment;

/**
 * CommentSearch represents the model behind the search form of `common\models\Comment`.
 */
class CommentSearch extends Comment
{
//    public function attributes(){
//        return array_merge(parent::attributes(),['title']);
//    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'u_id','rep_id'], 'integer'],
            [['content', 'type', 'flag', 'unique_key'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [                  
                    'flag' => SORT_DESC,
                    'ctime' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'u_id' => $this->u_id,
            'ctime' => $this->ctime,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'unique_key', $this->unique_key])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'flag', $this->flag]);
//
//        $query->join('inner join','success_example','success_example.unique_key = comment.unique_key');
//        $query->join('inner join','data_manage','data_manage.unique_key = comment.unique_key');
//        $query->andFilterWhere(['like','success_example.title',$this->title]);
//        $query->orFilterWhere(['like','data_manage.title',$this->title]);
        return $dataProvider;
    }
}
