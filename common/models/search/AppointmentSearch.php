<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Appointment;
use yii;

class AppointmentSearch extends Appointment
{
    public $doctor_name;
    public $user_name;
    public $clinic_name;

    public function rules()
    {
        return [
            [['id', 'user_id', 'doctor_id', 'clinic_id', 'price'], 'integer'],
            [['appointment_date', 'start_time', 'end_time', 'status', 'created_by', 'doctor_name', 'user_name', 'clinic_name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Appointment::find()->joinWith(['doctor', 'user', 'clinic','doctorDetails']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['appointment_date' => SORT_DESC]],
            'pagination' => ['pageSize' => 20],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1'); // return nothing if validation fails
            return $dataProvider;
        }

        $query->andFilterWhere([
            'appointment.id' => $this->id,
            'appointment.user_id' => Yii::$app->user->id,
            'appointment.doctor_id' => $this->doctor_id,
            'appointment.clinic_id' => $this->clinic_id,
            'appointment.price' => $this->price,
            'appointment_date' => $this->appointment_date,
        ]);

        $query->andFilterWhere(['like', 'appointment.status', $this->status])
              ->andFilterWhere(['like', 'appointment.created_by', $this->created_by])
              ->andFilterWhere(['like', 'doctor.username', $this->doctor_name])
              ->andFilterWhere(['like', 'user.username', $this->user_name])
              ->andFilterWhere(['like', 'clinic.name', $this->clinic_name]);

        return $dataProvider;
    }
}
