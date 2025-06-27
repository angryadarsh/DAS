<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "doctor".
 *
 * @property int $id
 * @property int $user_id
 * @property string $specialization
 * @property string $qualification
 * @property string $experience
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property Clinic[] $clinics
 */
class Doctor extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%doctor}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'specialization', 'qualification', 'experience'], 'required'],
            [['user_id'], 'integer'],
            [['specialization', 'qualification', 'experience'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true,
                'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Linked User',
            'specialization' => 'Specialization',
            'qualification' => 'Qualification',
            'experience' => 'Experience',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets the associated user (1-to-1)
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getDoctorClinics()
    {
        return $this->hasMany(DoctorClinic::class, ['doctor_id' => 'id']);
    }

    /**
     * The Clinic models for this doctor (many-to-many via doctor_clinic)
     */
    public function getClinics()
    {
        return $this->hasMany(Clinic::class, ['id' => 'clinic_id'])
                    ->via('doctorClinics');
    }

    /**
     * Weekly availability (doctor_schedule)
     */
    public function getDoctorSchedules()
    {
        return $this->hasMany(DoctorSchedule::class, ['doctor_id' => 'user_id']);
    }

    /**
     * Appointments where this user is the doctor
     */
    public function getAppointments()
    {
        return $this->hasMany(Appointment::class, ['doctor_id' => 'user_id']);
    }
}
