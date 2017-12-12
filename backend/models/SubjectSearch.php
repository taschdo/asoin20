<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Subject;

/**
 * SubjectSearch represents the model behind the search form about `backend\models\Subject`.
 */
class SubjectSearch extends Subject
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_parent', 'federal_district'], 'integer'],
            [['name', 'name_region', 'contact', 'ods'], 'safe'],
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
        $query = Subject::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(!empty($this->id_parent)) {
            $query->orFilterWhere([
                'id' => $this->id_parent,
            ]);
            $query->orFilterWhere([
                'id_parent' => $this->id_parent,
            ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
//            'id' => $this->id,
//            'id_parent' => $this->id_parent,
            'federal_district' => $this->federal_district,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'name_region', $this->name_region])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'ods', $this->ods]);

        return $dataProvider;
    }
}
