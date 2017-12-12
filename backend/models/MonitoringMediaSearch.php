<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MonitoringMedia;

/**
 * MonitoringMediaSearch represents the model behind the search form about `backend\models\MonitoringMedia`.
 */
class MonitoringMediaSearch extends MonitoringMedia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created', 'id_user'], 'integer'],
            [['name', 'avatar', 'url_media', 'url_news', 'url_rss', 'unit_news_all', 'unit_news_one', 'unit_title', 'unit_text',  'unit_time', 'unit_date', 'unit_url'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = MonitoringMedia::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ],
            'sort'=> ['defaultOrder' => ['name'=>SORT_ASC]]
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
            'created' => $this->created,
            'id_user' => $this->id_user,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'url_media', $this->url_media])
            ->andFilterWhere(['like', 'url_news', $this->url_news])
            ->andFilterWhere(['like', 'url_rss', $this->url_rss])
            ->andFilterWhere(['like', 'unit_news_all', $this->unit_news_all])
            ->andFilterWhere(['like', 'unit_news_one', $this->unit_news_one])
            ->andFilterWhere(['like', 'unit_title', $this->unit_title])
            ->andFilterWhere(['like', 'unit_description', $this->unit_description])
            ->andFilterWhere(['like', 'unit_text', $this->unit_text])
            ->andFilterWhere(['like', 'unit_date', $this->unit_date])
            ->andFilterWhere(['like', 'unit_url', $this->unit_url]);

        return $dataProvider;
    }
}
