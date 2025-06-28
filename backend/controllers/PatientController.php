<?php

namespace backend\controllers;

use Yii;

use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\Helper;
use yii\helpers\ArrayHelper;
use common\models\Appointment;

class PatientController extends Controller
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
                        'actions' => ['view', 'index'],
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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewAppointments($id)
    {
        $appointments = Appointment::find()->with(['user', 'doctor', 'clinic','doctorDetails'])->where(['user_id' => $id])->asArray()->all();
        $user = User::find()->where(['id' => $id])->one();
        return $this->render('view_appointments',['appointments'=>$appointments,'user'=>$user]);
    }
}