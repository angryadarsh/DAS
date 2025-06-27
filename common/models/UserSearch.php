<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email','role'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios(); 
    }

    public function search($params)
    {
        $query = User::find();

        $query->where(['role' => 'patient']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => ['pageSize' => 20],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // Filters
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
              ->andFilterWhere(['like', 'email', $this->email])
              ->andFilterWhere(['like', 'role', $this->role]);

        return $dataProvider;
    }
}