<?php

namespace app\models;
use Yii;

class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const ROLE_USER = 1;
    const ROLE_MODER = 5;
    const ROLE_ADMIN = 10;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!\Yii::$app->user->can($action->id)) {
                throw new ForbiddenHttpException('Access denied');
            }
            return true;
        } else {
            return false;
        }
    }

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username', 'password', 'first_name', 'last_name', 'email'], 'required'],
            [['username', 'email'], 'unique'],
            [['username', 'password', 'first_name', 'last_name', 'email'], 'string', 'max' => 64],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'first_name' => Yii::t('app', 'Firstname'),
            'last_name' => Yii::t('app', 'Lastname'),
            'email' => Yii::t('app', 'Email'),
            'authKey' => Yii::t('app', 'authKey'),
            'accessToken' => Yii::t('app', 'accessToken')
        ];
    }

    public static function findIdentity($id)
    {
        return (Users::find()->byPk($id)) ? new static(Users::find()->byPk($id)->one()) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $users = Users::find()->asArray()->all();
        foreach ($users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }
        return null;
    }

    public static function findByUsername($username)
    {
        $users = Users::find()->asArray()->all();
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                return new static($user);
            }
        }
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstname()
    {
        return $this->first_name;
    }

    public function getLastname()
    {
        return $this->last_name;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function setAuthKey($str)
    {
        $this->authKey = Yii::$app->getSecurity()->generatePasswordHash($str);
    }

    public function setToken($str)
    {
        $this->accessToken = Yii::$app->getSecurity()->generatePasswordHash($str);
    }

    public function setPassword($str)
    {
        $this->password = $str;
        $this->hashPassword();
    }

    public function hashPassword()
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
    }

    public function setFirstname($str)
    {
        $this->first_name = $str;
    }

    public function setLastname($str)
    {
        $this->last_name = $str;
    }

    public function setLanguage($str)
    {
        $this->language = $str;
    }

    public function getRole($groupId)
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'role_id'])
            ->viaTable('user_groups', ['user_id' => 'id'], function ($query) use ($groupId) {
                $query->andWhere(['group_id' => $groupId]);
            })->one();
    }
}