<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Doctor;

class DoctorSearch extends Doctor
{
    public $username;
    public $email;

    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['specialization', 'qualification', 'experience','username', 'email'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios(); // skip parent implementation
    }

    public function search($params)
    {
        $query = Doctor::find()->with('user');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
            
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1'); 
            return $dataProvider;
        }

        $query->andFilterWhere([
            'doctor.id' => $this->id,
            'doctor.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'doctor.specialization', $this->specialization])
              ->andFilterWhere(['like', 'doctor.qualification', $this->qualification])
              ->andFilterWhere(['like', 'doctor.experience', $this->experience])
              ->andFilterWhere(['like', 'user.username', $this->username])
              ->andFilterWhere(['like', 'user.email', $this->email]);

        return $dataProvider;
    }
}
