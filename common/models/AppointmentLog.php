<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "appointment_log".
 *
 * @property int $id
 * @property int $appointment_id
 * @property string|null $action
 * @property int|null $performed_by
 * @property int|null $performed_at
 * @property string|null $details
 *
 * @property Appointment $appointment
 * @property User $performedBy
 */
class AppointmentLog extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appointment_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['action', 'performed_by', 'performed_at', 'details'], 'default', 'value' => null],
            [['appointment_id'], 'required'],
            [['appointment_id', 'performed_by', 'performed_at'], 'integer'],
            [['details'], 'string'],
            [['action'], 'string', 'max' => 50],
            [['appointment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Appointment::class, 'targetAttribute' => ['appointment_id' => 'id']],
            [['performed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['performed_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appointment_id' => 'Appointment ID',
            'action' => 'Action',
            'performed_by' => 'Performed By',
            'performed_at' => 'Performed At',
            'details' => 'Details',
        ];
    }

    /**
     * Gets query for [[Appointment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppointment()
    {
        return $this->hasOne(Appointment::class, ['id' => 'appointment_id']);
    }

    /**
     * Gets query for [[PerformedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformedBy()
    {
        return $this->hasOne(User::class, ['id' => 'performed_by']);
    }

}
