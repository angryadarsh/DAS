<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "appointment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $doctor_id
 * @property int $clinic_id
 * @property string $appointment_date
 * @property string $start_time
 * @property string $end_time
 * @property int|null $duration_minutes
 * @property int $price
 * @property string|null $status
 * @property string $created_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AppointmentEmail[] $appointmentEmails
 * @property AppointmentLog[] $appointmentLogs
 * @property Clinic $clinic
 * @property User $doctor
 * @property User $user
 */
class Appointment extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_BOOKED = 'booked';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';
    const CREATED_BY_USER = 'patient';
    const CREATED_BY_DOCTOR = 'doctor';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appointment';
    }
    /**
     * {@inheritdoc}
     */
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
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['duration_minutes'], 'default', 'value' => 10],
            [['status'], 'default', 'value' => 'booked'],
            [['user_id', 'doctor_id', 'clinic_id', 'appointment_date', 'start_time', 'end_time', 'price', 'created_by'], 'required'],
            [['user_id', 'doctor_id', 'clinic_id', 'duration_minutes', 'price', 'created_at', 'updated_at'], 'integer'],
            [['appointment_date', 'start_time', 'end_time'], 'safe'],
            [['status', 'created_by'], 'string'],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            ['created_by', 'in', 'range' => array_keys(self::optsCreatedBy())],
            [['clinic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clinic::class, 'targetAttribute' => ['clinic_id' => 'id']],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['doctor_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'doctor_id' => 'Doctor ID',
            'clinic_id' => 'Clinic ID',
            'appointment_date' => 'Appointment Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'duration_minutes' => 'Duration Minutes',
            'price' => 'Price',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AppointmentEmails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppointmentEmails()
    {
        return $this->hasMany(AppointmentEmail::class, ['appointment_id' => 'id']);
    }

    /**
     * Gets query for [[AppointmentLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppointmentLogs()
    {
        return $this->hasMany(AppointmentLog::class, ['appointment_id' => 'id']);
    }

    /**
     * Gets query for [[Clinic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClinic()
    {
        return $this->hasOne(Clinic::class, ['id' => 'clinic_id']);
    }

    /**
     * Gets query for [[Doctor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(User::class, ['id' => 'doctor_id']);
    }

    public function getDoctorDetails()
    {
        return $this->hasOne(Doctor::class, ['user_id' => 'doctor_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_BOOKED => 'booked',
            self::STATUS_CANCELLED => 'cancelled',
            self::STATUS_COMPLETED => 'completed',
        ];
    }

    /**
     * column created_by ENUM value labels
     * @return string[]
     */
    public static function optsCreatedBy()
    {
        return [
            self::CREATED_BY_USER => 'user',
            self::CREATED_BY_DOCTOR => 'doctor',
        ];
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusBooked()
    {
        return $this->status === self::STATUS_BOOKED;
    }

    public function setStatusToBooked()
    {
        $this->status = self::STATUS_BOOKED;
    }

    /**
     * @return bool
     */
    public function isStatusCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function setStatusToCancelled()
    {
        $this->status = self::STATUS_CANCELLED;
    }

    /**
     * @return bool
     */
    public function isStatusCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function setStatusToCompleted()
    {
        $this->status = self::STATUS_COMPLETED;
    }

    /**
     * @return string
     */
    public function displayCreatedBy()
    {
        return self::optsCreatedBy()[$this->created_by];
    }

    /**
     * @return bool
     */
    public function isCreatedByUser()
    {
        return $this->created_by === self::CREATED_BY_USER;
    }

    public function setCreatedByToUser()
    {
        $this->created_by = self::CREATED_BY_USER;
    }

    /**
     * @return bool
     */
    public function isCreatedByDoctor()
    {
        return $this->created_by === self::CREATED_BY_DOCTOR;
    }

    public function setCreatedByToDoctor()
    {
        $this->created_by = self::CREATED_BY_DOCTOR;
    }
}
