<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class UserController extends Controller
{
    public function actionIndex()
    {
        return ExitCode::OK;
    }

    public function actionCreateAdmin($email)
    {
        $model = User::find()->where(['username' => $email])->one();
        if (empty($model)) {
            $user = new User();
            $user->username = $email;
            $user->email = $email;
            $user->role = User::ROLE_ADMIN;
            $user->created_at = time();
            $user->updated_at = time();
            $password = Yii::$app->security->generateRandomString(8);
            $user->setPassword($password);
            $user->generateAuthKey();
            if ($user->save()) {
                echo "Админ создан, логин: {$email}, пароль: {$password}";
            }
        } else {
            echo 'Админ с таким логином уже есть';
        }
        return ExitCode::OK;
    }
}
