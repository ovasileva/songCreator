<?php

namespace app\models;
use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $repeat_password;
    public $first_name;
    public $last_name;
    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password', 'first_name', 'last_name', 'email', 'repeat_password'], 'required'],
            ['email', 'email'],
            [['username', 'password', 'first_name', 'last_name', 'email'], 'string', 'max' => 64],
            ['repeat_password', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('app', 'Passwords don\'t match')]
        ];
    }

    public function register()
    {
        if($this->validate()) {
            $this->_user = new Users();
            $this->_user->load(['Users' => $this->attributes]);
            $this->_user->hashPassword();
            $this->_user->setToken("{$this->_user->getId()}{$this->_user->username}token");
            $this->_user->setAuthKey("{$this->_user->getId()}{$this->_user->username}authkey");
            //$this->_user->setLanguage(Yii::$app->language);
            if(!$this->_user->save()) {
                $this->addErrors($this->_user->errors);
            }
            else
            {
                $auth = Yii::$app->authManager;
                $auth->assign(Yii::$app->authManager->getRole('user'),$this->_user->id);
                return true;
            }
        }
        return false;
    }
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'repeat_password' => Yii::t('app', 'Repeat Password'),
            'first_name' => Yii::t('app', 'Firstname'),
            'last_name' => Yii::t('app', 'Lastname'),
        ];
    }
}