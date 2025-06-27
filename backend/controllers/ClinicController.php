<?php

namespace backend\controllers;

use yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Clinic;
use yii\data\ActiveDataProvider;
use common\components\Helper;
use yii\helpers\ArrayHelper;

class ClinicController extends \yii\web\Controller
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
                    
                ],
            ],
            
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Clinic::find(),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate()
    {
        $model = new Clinic();
        
        $states = ArrayHelper::map(Helper::getStates(), 'name', 'name');

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['index']);
            } else {
                Yii::error('Clinic not saved: ' . json_encode($model->errors), __METHOD__);
                Yii::$app->session->setFlash('error', 'Failed to save clinic. Please fix the errors.');
            }
        }

        return $this->render('create', ['model' => $model,'states'=>$states]);
    }

    public function actionGetCities(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $stateCode = Yii::$app->request->post('state_code');
        $cities = Helper::getCities($stateCode);
        return $cities;
    }

}
