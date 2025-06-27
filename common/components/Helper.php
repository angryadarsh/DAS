<?php

namespace common\components;

use Yii;
use yii\httpclient\Client;
use common\models\Clinic;
use common\models\User;
use yii\helpers\ArrayHelper;

class Helper
{

    public static function request($method, $url, $headers = [], $data = [])
    {
        $client = new Client();

        try {
            $response = $client->createRequest()
                ->setMethod(strtoupper($method))
                ->setUrl($url)
                ->addHeaders(array_merge([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ], $headers))
                ->setData($data)
                ->send();

            if ($response->isOk) {
                return $response->data;
            }

            Yii::error("API Error: {$response->statusCode} - {$response->content}");
            return [
                'success' => false,
                'status' => $response->statusCode,
                'error' => $response->content,
            ];
        } catch (\Exception $e) {
            Yii::error("API Exception: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public static function getStates(){
        $responseArray = self::request('POST', 'https://countriesnow.space/api/v0.1/countries/states', [], [
            'country' => 'India'
        ]);

        if($responseArray['error'] == false){
            return $responseArray['data']['states'];
        }
    }

    public static function getCities($state){

        $responseArray = self::request('POST', 'https://countriesnow.space/api/v0.1/countries/state/cities', [], [
            'country' => 'India',
            'state' => $state
        ]);

        if($responseArray['error'] == false){
            return $responseArray['data'];
        }
    }

    public static function authAssign($role, $userId){
        $auth = Yii::$app->authManager;
        $auth->assign($auth->getRole($role), $userId);
        return true; 
    }

    public static function getClinics(){
        $clinics = Clinic::find()->all();
        return ArrayHelper::map($clinics, 'id', 'name');
    }

    public static function getClinicDoctors($clinicId){
        $doctors = User::find()
        ->alias('u')
        ->innerJoin(DoctorClinic::tableName() . ' dc', 'dc.doctor_id = u.id')
        ->where([
            'dc.clinic_id' => $clinicId,
            'u.role'       => 'doctor',
        ])
        ->all();
    }

}
