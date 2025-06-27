<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Clear existing
        $auth->removeAll();

        // Create roles
        $superadmin = $auth->createRole('superadmin');
        $auth->add($superadmin);

        $doctor = $auth->createRole('doctor');
        $auth->add($doctor);

        $patient = $auth->createRole('patient');
        $auth->add($patient);

        // Create permissions
        $manageAll = $auth->createPermission('manageAll');
        $manageAll->description = 'Full access to system';
        $auth->add($manageAll);

        $viewPatients = $auth->createPermission('viewPatients');
        $auth->add($viewPatients);

        $bookAppointment = $auth->createPermission('bookAppointment');
        $auth->add($bookAppointment);

        // Assign permissions
        $auth->addChild($superadmin, $manageAll);
        $auth->addChild($doctor, $viewPatients);
        $auth->addChild($patient, $bookAppointment);

        //  make superadmin inherit other roles
        $auth->addChild($superadmin, $doctor);
        $auth->addChild($superadmin, $patient);

        echo "Roles and permissions created.\n";
    }

    public function actionAssign()
    {
        $auth = Yii::$app->authManager;

        // Assign roles to user IDs
        // $auth->assign($auth->getRole('superadmin'), 1); // Admin
        $auth->assign($auth->getRole('doctor'), 6);     // Doctor
        // $auth->assign($auth->getRole('patient'), 3);    // Patient

        echo "Roles assigned.\n";
    }
}
