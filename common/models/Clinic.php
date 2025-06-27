<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "clinic".
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $pincode
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Appointment[] $appointments
 * @property DoctorClinic[] $doctorClinics
 */
class Clinic extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clinic';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','address', 'city', 'state', 'pincode'], 'required'],
            // [['name','address', 'city', 'state', 'pincode', 'created_at', 'updated_at'], 'default', 'value' => null],
            // [['name'], 'required'],
            [['address'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['city', 'state'], 'string', 'max' => 100],
            [['pincode'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'pincode' => 'Pincode',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Appointments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppointments()
    {
        return $this->hasMany(Appointment::class, ['clinic_id' => 'id']);
    }

    /**
     * Gets query for [[DoctorClinics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoctorClinics()
    {
        return $this->hasMany(DoctorClinic::class, ['clinic_id' => 'id']);
    }

}
