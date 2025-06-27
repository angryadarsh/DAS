<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use comman\models\Doctor;
use common\models\DoctorClinic;
use common\models\DoctorSearch;
use common\models\DoctorSchedule;

/*
 * DoctorController implements the CRUD actions for Doctor model.
*/

class DoctorScheduleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'schedule'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['schedule'],
                        'allow' => true,
                        'roles' => ['doctor'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Doctor models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSchedule()
    {
        $doctorId = Yii::$app->user->id;
        $models = DoctorSchedule::findAll(['doctor_id' => $doctorId]);

        // If no schedules exist yet, you might initialize one per day:
        if (empty($models)) {
            foreach (DoctorSchedule::optsDayOfWeek() as $dayCode => $dayLabel) {
                $m = new DoctorSchedule();
                $m->doctor_id = $doctorId;
                $m->day_of_week = $dayCode;
                $models[] = $m;
            }
        }

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post('DoctorSchedule', []);
            // Delete old then rebuild from POST:
            DoctorSchedule::deleteAll(['doctor_id' => $doctorId]);

            foreach ($post as $i => $attrs) {
                $schedule = new DoctorSchedule();
                $schedule->attributes = $attrs;
                $schedule->doctor_id = $doctorId;
                if (!$schedule->save()) {
                    Yii::$app->session->setFlash('error', "Failed on row {$i}: " . json_encode($schedule->errors));
                }
            }

            Yii::$app->session->setFlash('success', 'Schedule updated');
            return $this->refresh();
        }

        return $this->render('schedule', [
            'models' => $models,
        ]);
    }

}