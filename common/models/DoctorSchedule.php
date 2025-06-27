<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "doctor_schedule".
 *
 * @property int $id
 * @property int $doctor_id
 * @property string $day_of_week
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int|null $is_holiday
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $doctor
 */
class DoctorSchedule extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const DAY_OF_WEEK_MON = 'Mon';
    const DAY_OF_WEEK_TUE = 'Tue';
    const DAY_OF_WEEK_WED = 'Wed';
    const DAY_OF_WEEK_THU = 'Thu';
    const DAY_OF_WEEK_FRI = 'Fri';
    const DAY_OF_WEEK_SAT = 'Sat';
    const DAY_OF_WEEK_SUN = 'Sun';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctor_schedule';
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
            [['start_time', 'end_time', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['is_holiday'], 'default', 'value' => 0],
            [['doctor_id', 'day_of_week'], 'required'],
            [['doctor_id', 'is_holiday', 'created_at', 'updated_at'], 'integer'],
            [['day_of_week'], 'string'],
            [['start_time', 'end_time'], 'safe'],
            ['day_of_week', 'in', 'range' => array_keys(self::optsDayOfWeek())],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['doctor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => 'Doctor ID',
            'day_of_week' => 'Day Of Week',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'is_holiday' => 'Is Holiday',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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


    /**
     * column day_of_week ENUM value labels
     * @return string[]
     */
    public static function optsDayOfWeek()
    {
        return [
            self::DAY_OF_WEEK_MON => 'Mon',
            self::DAY_OF_WEEK_TUE => 'Tue',
            self::DAY_OF_WEEK_WED => 'Wed',
            self::DAY_OF_WEEK_THU => 'Thu',
            self::DAY_OF_WEEK_FRI => 'Fri',
            self::DAY_OF_WEEK_SAT => 'Sat',
            self::DAY_OF_WEEK_SUN => 'Sun',
        ];
    }

    /**
     * @return string
     */
    public function displayDayOfWeek()
    {
        return self::optsDayOfWeek()[$this->day_of_week];
    }

    /**
     * @return bool
     */
    public function isDayOfWeekMon()
    {
        return $this->day_of_week === self::DAY_OF_WEEK_MON;
    }

    public function setDayOfWeekToMon()
    {
        $this->day_of_week = self::DAY_OF_WEEK_MON;
    }

    /**
     * @return bool
     */
    public function isDayOfWeekTue()
    {
        return $this->day_of_week === self::DAY_OF_WEEK_TUE;
    }

    public function setDayOfWeekToTue()
    {
        $this->day_of_week = self::DAY_OF_WEEK_TUE;
    }

    /**
     * @return bool
     */
    public function isDayOfWeekWed()
    {
        return $this->day_of_week === self::DAY_OF_WEEK_WED;
    }

    public function setDayOfWeekToWed()
    {
        $this->day_of_week = self::DAY_OF_WEEK_WED;
    }

    /**
     * @return bool
     */
    public function isDayOfWeekThu()
    {
        return $this->day_of_week === self::DAY_OF_WEEK_THU;
    }

    public function setDayOfWeekToThu()
    {
        $this->day_of_week = self::DAY_OF_WEEK_THU;
    }

    /**
     * @return bool
     */
    public function isDayOfWeekFri()
    {
        return $this->day_of_week === self::DAY_OF_WEEK_FRI;
    }

    public function setDayOfWeekToFri()
    {
        $this->day_of_week = self::DAY_OF_WEEK_FRI;
    }

    /**
     * @return bool
     */
    public function isDayOfWeekSat()
    {
        return $this->day_of_week === self::DAY_OF_WEEK_SAT;
    }

    public function setDayOfWeekToSat()
    {
        $this->day_of_week = self::DAY_OF_WEEK_SAT;
    }

    /**
     * @return bool
     */
    public function isDayOfWeekSun()
    {
        return $this->day_of_week === self::DAY_OF_WEEK_SUN;
    }

    public function setDayOfWeekToSun()
    {
        $this->day_of_week = self::DAY_OF_WEEK_SUN;
    }
}
