<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DataManage;

/**
 * DataManageSearch represents the model behind the search form of `common\models\DataManage`.
 */
class DataManageSearch extends DataManage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        // 去掉 “增加时间” 和 “浏览量” 搜索，Bery 2018-11-22
        return [
            [['id', 'car_id', 'code_id'], 'integer'],
            [['title', 'url', 'content', 'type','is_top', 'utime', 'isvip_view','unique_key','view_level'], 'safe'],
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
        $query = DataManage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
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
            'car_id' => $this->car_id,
            'code_id' => $this->code_id,
            'ctime' => $this->ctime,
            'utime' => $this->utime,
            'page_view' => $this->page_view,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'unique_key', $this->unique_key])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'is_top', $this->is_top])
            ->andFilterWhere(['like', 'isvip_view', $this->isvip_view])
            ->andFilterWhere(['like', 'view_level', $this->view_level]);   ;

        return $dataProvider;
    }
}
