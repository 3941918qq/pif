<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 */
class UserSearch extends User
{
//     public function attributes(){
//        return array_merge(parent::attributes(),['title']);
//    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'updated_at'], 'integer'],          // 去掉按照 “加入时间” 搜索，Bery 2018-11-22
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'name', 'img_url', 'area', 'company', 'address', 'comment', 'is_vip', 'vip_endtime', 'sex','score'], 'safe'],
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
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'vip_endtime' => $this->vip_endtime,
            'score' => $this->score,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'img_url', $this->img_url])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'is_vip', $this->is_vip])
            ->andFilterWhere(['like', 'sex', $this->sex]);

        return $dataProvider;
    }
}
