<?php

namespace app\models;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;

class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
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
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'authKey' => Yii::t('app', 'authKey'),
            'accessToken' => Yii::t('app', 'accessToken'),
        ];
    }

    public static function find()
    {
        return new UsersQuery(get_called_class());
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

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function hashPassword()
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
    }

    public function setToken($str)
    {
        $this->accessToken = Yii::$app->getSecurity()->generatePasswordHash($str);
    }

    public function setAuthKey($str)
    {
        $this->authKey = Yii::$app->getSecurity()->generatePasswordHash($str);
    }

    public function getRole()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id'])->one()->item_name;
    }

    public function getFavoriteSong($song_id)
    {
        return $this->hasMany(Songs::className(), ['id' => 'song_id'])->viaTable('favorite_songs', ['user_id' => 'id'])->where(['id' => $song_id])->one();
    }

    public function getViewedSongs()
    {
        return $this->hasMany(Songs::className(), ['id' => 'song_id'])->viaTable('viewed_songs', ['user_id' => 'id']);
    }

    public function getLastComment($song_id)
    {
        return $this->hasMany(Comments::className(), ['author_id' => 'id'])->where(['song_id' => $song_id])->orderBy('created_at DESC')->limit(1)->one();
    }

    public function getFullName ()
    {
        return $this->username . ' (' . $this->first_name . ' ' . $this->last_name . ')';
    }

}