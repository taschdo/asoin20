<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Oksion;

/**
 * OksionSearch represents the model behind the search form about `backend\models\Oksion`.
 */
class OksionSearch extends Oksion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_subject', 'working', 'type', 'view', 'reason'], 'integer'],
            [['city', 'address'], 'safe'],
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
        $query = Oksion::find();

        if(!empty(Yii::$app->user->identity->id_subject)) $query->andWhere(['id_subject'=>Yii::$app->user->identity->id_subject]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'id_subject' => $this->id_subject,
            'type' => $this->type,
            'view' => $this->view,
            'working' => $this->working,
            'reason' => $this->reason,
        ]);

        $query->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
