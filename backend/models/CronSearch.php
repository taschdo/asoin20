<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cron;

/**
 * CronSearch represents the model behind the search form about `backend\models\Cron`.
 */
class CronSearch extends Cron
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'time_begin', 'time_end', 'time_run', 'number_unit', 'number_bd'], 'integer'],
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
        $query = Cron::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
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
            'time_begin' => $this->time_begin,
            'time_end' => $this->time_end,
            'time_run' => $this->time_run,
            'number_unit' => $this->number_unit,
            'number_bd' => $this->number_bd,
        ]);

        return $dataProvider;
    }
}