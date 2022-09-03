<?php
namespace app\models;


class UserAPI extends \app\models\User
{
    public function fields()
    {
        return ['id', 'username', 'email', 'phone', 'role'];
    }

    public function extraFields()
    {
        return ['profile'];
    }

}