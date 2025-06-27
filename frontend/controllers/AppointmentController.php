<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Appointment;
use common\models\AppointmentEmail;
use common\models\AppointmentLog;
use common\models\User;
use common\models\Doctor;
use common\models\DoctorClinic;
use common\models\Clinic;
use common\components\Helper;
use yii\helpers\ArrayHelper;
use common\models\search\AppointmentSearch;

/*
 * AppointmentController implements the CRUD actions for Appointment model.
*/

class AppointmentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
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

    public function actionIndex(){
        $searchModel = new AppointmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Appointment models.
     * @return mixed
     */
    public function actionBookAppointment()
    {
        try{
            $appointment = new Appointment();
            $clinic = Helper::getClinics();
            if ($appointment->load(Yii::$app->request->post()) ) {
                $appointment->user_id = Yii::$app->user->id;
                $appointment->status = Appointment::STATUS_BOOKED;
                $appointment->created_by = Yii::$app->user->identity->role; 
                if($appointment->validate()){
                    if ($appointment->save()) {
                        $appointment = Appointment::find()
                            ->where(['id' => $appointment->id])
                            ->with(['user', 'doctor', 'clinic'])
                            ->one();
                        $this->sendConfirmationMail($appointment);
                        Yii::$app->session->setFlash('success', 'Appointment booked successfully.');
                        return $this->refresh(); 
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to save appointment.');
                    }
                } else {
                    if ($appointment->hasErrors()) {
                        echo "<pre>";
                        print_r($appointment->getErrors());
                        echo "</pre>";
                        exit;
                    }
                }
            }
            
            return $this->render('bookingappointment',['appointment'=>$appointment,'clinic'=>$clinic]);
        }catch(Exception $e){
            echo "<pre>";
            print_r($e);
            echo "</pre>";
            exit;
        }
    }   
    public function actionGetBookedSlots(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       $appointments = [
            [
                "title" => "Booked",
                "start" => "2025-06-24T10:00:00",
                "end" => "2025-06-24T10:30:00",
                "color" => "red"
            ],
            [
                "title" => "Booked",
                "start" => "2025-06-24T14:00:00",
                "end" => "2025-06-24T14:30:00",
                "color" => "red"
            ]
        ];                               
        return  $appointments ;
    }

    public  function actionEditAppointment($id){
        try {
            $appointment = Appointment::findOne($id);

            if (!$appointment) {
                throw new \yii\web\NotFoundHttpException("Appointment not found.");
            }

            $clinic = Helper::getClinics();
            $doctors = [];

            if ($appointment->clinic_id) {
                $doctors = \yii\helpers\ArrayHelper::map(
                    User::find()->where(['id' => $appointment->doctor_id])->all(), 
                    'id', 
                    'username'
                );
            }
            if ($appointment->load(Yii::$app->request->post())) {
                $appointment->user_id = Yii::$app->user->id;
                $appointment->status = Appointment::STATUS_BOOKED;
                $appointment->created_by = Yii::$app->user->identity->role;

                if ($appointment->validate()) {
                    if ($appointment->save()) {
                        $appointment = Appointment::find()
                            ->where(['id' => $appointment->id])
                            ->with(['user', 'doctor', 'clinic','doctorDetails'])
                            ->one();

                        $this->sendConfirmationMail($appointment); 
                        Yii::$app->session->setFlash('success', 'Appointment updated successfully.');
                        return $this->refresh(); 
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to update appointment.');
                    }
                } else {
                    if ($appointment->hasErrors()) {
                        echo "<pre>";
                        print_r($appointment->getErrors());
                        echo "</pre>";
                        exit;
                    }
                }
            }

            return $this->render('edit_appointment', [
                'appointment' => $appointment,
                'clinic' => $clinic,
                'doctors' => $doctors,
            ]);

        } catch (\Throwable $e) {
            Yii::error("Edit failed: " . $e->getMessage(), __METHOD__);
            throw $e;
        }
        // return $this->render('edit_appointment');
    }

    public function actionViewAppointment($id){
        $appointment = Appointment::find()->where(['id' => $id])->with(['user', 'doctor', 'clinic','doctorDetails'])->one();
        return $this->render('view_appointment',['appointment'=>$appointment]);
    }

    public function actionGetDoctorsByClinic($clinicId)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $doctorClinics = DoctorClinic::find()
            ->where(['clinic_id' => $clinicId])
            ->with(['doctor']) 
            ->all();

        $doctors = ArrayHelper::map(
            array_column($doctorClinics, 'doctor'),
            'id', // assuming 'id' is doctor's ID
            'username' // or 'name' depending on your user model
        );

        return $doctors;
    }

    private function sendConfirmationMail($appointment) {
         // Send email confirmation
       Yii::$app
            ->mailer
            ->compose(
                ['html' => 'appointmentConfirmation-html'],
                ['appointment' => $appointment]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo(Yii::$app->user->identity->email)
            ->setSubject('Appointment Confirmation')
            ->send();
    }
}