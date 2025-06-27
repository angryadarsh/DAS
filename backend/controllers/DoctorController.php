<?php

namespace backend\controllers;

use Yii;
use common\models\Doctor;
use common\models\User;
use common\models\Clinic;
use common\models\DoctorClinic;
use common\models\DoctorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\Helper;
use yii\helpers\ArrayHelper;
use common\models\Appointment;

class DoctorController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['superadmin'],
                    ],
                    [
                        'actions' => ['view', 'index','create','update','delete','link-clinic','view-calender'],
                        'allow' => true,
                        'roles' => ['superadmin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => ['delete' => ['POST']],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new DoctorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
               
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        // try {
            $user = new User();
            $user->scenario = User::SCENARIO_DOCTOR_CREATE;
            $doctor = new Doctor();

            if ($user->load(Yii::$app->request->post()) && $doctor->load(Yii::$app->request->post())) {
                $user->role = 'doctor';
                $user->setPassword($user->password_hash); 
                $user->generateAuthKey();
                $user->generateEmailVerificationToken();
            
                if ($user->save()) {
                    $this->sendEmail($user);
                    $doctor->user_id = $user->id;
                    if ($doctor->save()) {
                        Helper::authAssign($user->role, $user->id);
                        Yii::$app->session->setFlash('success', 'Doctor created successfully.');
                        return $this->redirect(['index']);
                    }
                }
                Yii::error('Doctor create faileds: ' . $e->getMessage(), __METHOD__);
                Yii::$app->session->setFlash('error', 'Failed to save doctor.');
            }

            return $this->render('create', [
                'user' => $user,
                'doctor' => $doctor
            ]);
        // } catch (\Exception $e) {
        //     Yii::error('Doctor create failed: ' . $e->getMessage(), __METHOD__);
        //     Yii::$app->session->setFlash('error', 'Failed to save doctor.'.json_encode($e->getMessage()));        
        //     return $this->redirect(['index']);
        // }
    }

    public function actionUpdate($id)
    {
        $doctor = $this->findModel($id); 
        if ($doctor->load(Yii::$app->request->post())) {
            if ($doctor->save()) {
                Yii::$app->session->setFlash('success', 'Doctor updated successfully.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update doctor.');
            }
        }

        return $this->render('update', [
            'model' => $doctor,
        ]);

    }

    public function actionDelete($id)
    {
        $doctor = $this->findModel($id);

        DoctorClinic::deleteAll(['doctor_id' => $doctor->id]);

        if ($doctor->user_id) {
            $user =User::findOne($doctor->user_id);
            if ($user) {
                $user->status = User::STATUS_DELETED;
                $user->save();
                
            }
        }
        if($doctor->delete()){
             Yii::$app->session->setFlash('success', 'Doctor and associated records deleted successfully.');
            return $this->redirect(['index']);
        }
    }

    public function actionLinkClinic($id){
       try {
            $doctor = $this->findModel($id); 
            $model = new DoctorClinic();

            $model->clinic_id = ArrayHelper::getColumn(
                DoctorClinic::find()->where(['doctor_id' => $doctor->id])->asArray()->all(),
                'clinic_id'
            );

            $clinic = ArrayHelper::map(Clinic::find()->all(), 'id', 'name');
            if (Yii::$app->request->isPost) {
                $postData = Yii::$app->request->post();

                if (isset($postData['DoctorClinic']['clinic_id']) && is_array($postData['DoctorClinic']['clinic_id'])) {
                    $selectedClinics = $postData['DoctorClinic']['clinic_id'];
                    DoctorClinic::deleteAll(['doctor_id' => $doctor->id]);

                    foreach ($selectedClinics as $clinicId) {
                        $mapping = new DoctorClinic();
                        $mapping->doctor_id = $doctor->user_id;
                        $mapping->clinic_id = $clinicId;
                        if (!$mapping->save()) {
                            Yii::error("Failed to save clinic mapping for doctor {$doctor->id}", __METHOD__);
                            Yii::$app->session->setFlash('error', 'Failed to update clinic mappings.');
                            return $this->refresh();
                        }
                    }

                    Yii::$app->session->setFlash('success', 'Clinics updated successfully.');
                    return $this->redirect(['view', 'id' => $doctor->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Please select at least one clinic.');
                }
            }
            return $this->render('link_clinic', [
                'model' => $model,
                'clinic' => $clinic,
            ]);
        } catch (\Throwable $e) {
            Yii::error("Failed to load link clinic for doctor ID {$id}: " . $e->getMessage(), __METHOD__);
            Yii::$app->session->setFlash('error', 'Failed to load clinic linking page.');
            return $this->redirect(['index']); 
        }
    }

    public function actionViewCalender($id){

        // schedule of doctor
        $doctorSchedules = Doctor::find()->where(['id' => $id])->with('doctorSchedules')->one();
        $days = [];
        if($doctorSchedules->doctorSchedules){
            foreach ($doctorSchedules->doctorSchedules as $key => $value) {
                $days[$value->day_of_week] = [$value->start_time,$value->end_time,$value->is_holiday];
            }
        }
        return $this->render('view_calender',['doctorSchedules'=>$doctorSchedules,'days'=>$days,'id'=>$id]);
    }
    public function actionGetBookedSlots($id){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $appointments = Appointment::find()->where(['user_id' => $id])->asArray()->all();
        $data = [];
        if ($appointments) {
            foreach ($appointments as $key => $value) {
              $data[] = [
                "title" => $value['status'] ." Total Duration ". $value['duration_minutes'],
                "start" => $value['appointment_date'] . " " . $value['start_time'],
                "end" => $value['appointment_date'] . " " . $value['end_time'],
                "color" => "sky-400"
              ];
            }
           
        }
        
        return $data ;  
    }

    public function actionViewAllAppointments()
    {
       
        return $this->render('view_all_appointments');
    }

    protected function findModel($id)
    {
        $model = Doctor::find()->with('user')->where(['id' => $id])->one();

        if ($model !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested doctor does not exist.');
    }

    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
