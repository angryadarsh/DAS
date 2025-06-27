<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "appointment_email".
 *
 * @property int $id
 * @property int $appointment_id
 * @property string|null $subject
 * @property string|null $email_content
 * @property int|null $generated_at
 *
 * @property Appointment $appointment
 */
class AppointmentEmail extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appointment_email';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'email_content', 'generated_at'], 'default', 'value' => null],
            [['appointment_id'], 'required'],
            [['appointment_id', 'generated_at'], 'integer'],
            [['email_content'], 'string'],
            [['subject'], 'string', 'max' => 255],
            [['appointment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Appointment::class, 'targetAttribute' => ['appointment_id' => 'id']],
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
            'subject' => 'Subject',
            'email_content' => 'Email Content',
            'generated_at' => 'Generated At',
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

}
