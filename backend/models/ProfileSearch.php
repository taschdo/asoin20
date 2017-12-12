<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Profile;

/**
 * ProfileSearch represents the model behind the search form about `backend\models\Profile`.
 */
class ProfileSearch extends Profile
{
    /**
     * @inheritdoc
     */

    public $userName;

    public $userEmail;

    public $fio;

    public function rules()
    {
        return [
            [['id_user'], 'integer'],
            [['date_birth'], 'string', 'max' => 20],
            [['name', 'surname', 'middle_name', 'fio', 'avatar', 'mobile_phone', 'work_phone', 'position', 'userName', 'userEmail'], 'safe'],
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
        $query = Profile::find();

        $query->joinWith(['user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['userName'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['asoin_user.username' => SORT_ASC],
            'desc' => ['asoin_user.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['userEmail'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['asoin_user.email' => SORT_ASC],
            'desc' => ['asoin_user.email' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['fio'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['surname' => SORT_ASC],
            'desc' => ['surname' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_user' => $this->id_user,
//            'date_birth' => $this->date_birth,
        ]);

        if (!empty($params['ProfileSearch']['date_birth']))
            $query->andFilterWhere(['date_birth' => strtotime($params['ProfileSearch']['date_birth'])]);
        else
            $query->andFilterWhere(['date_birth' => $this->date_birth]);

        $query->orFilterWhere(['like', 'name', $this->fio])
            ->orFilterWhere(['like', 'surname', $this->fio])
            ->orFilterWhere(['like', 'middle_name', $this->fio])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'mobile_phone', $this->mobile_phone])
            ->andFilterWhere(['like', 'work_phone', $this->work_phone])
            ->andFilterWhere(['like', 'position', $this->position]);

        $query->andFilterWhere(['like', 'asoin_user.username', $this->userName]);

        $query->andFilterWhere(['like', 'asoin_user.email', $this->userEmail]);

        return $dataProvider;
    }
}
