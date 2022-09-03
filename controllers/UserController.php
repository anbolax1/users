<?php

namespace app\controllers;

use app\models\User;
use app\models\UserAPI;
use Yii;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

class UserController extends ActiveController
{
    public $modelClass = UserAPI::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBasicAuth::class;
        $behaviors['authenticator']['auth'] = function ($username, $password) {
            $user = User::find()->where(['username' => $username])->one();
            if(!empty($user) && $user->validatePassword($password)) {
                return $user;
            }
           return null;
        };

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@']
                ]
            ]
        ];
        return $behaviors;
    }

    public function auth($username, $password)
    {
        $user = User::findOne(['username' => $username]);
        if ($user->validatePassword($password)) {
            return true;
        }
        else {
            return false;
        }
    }


//    public function actionIndex()
//    {
//        $payroll_model = new User();
//        $dataProvider = $payroll_model->getUsers(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//        ]);
//    }

}
