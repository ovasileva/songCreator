<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\Users;
use app\models\Songs;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        //if(Yii::$app->user->isGuest) {var_dump('I am guest'); die();};
      //  var_dump(Yii::$app->user); die();
        if(!Yii::$app->user->isGuest) {
            return $this->redirect(['song/']);
        }
        return $this->render('index');
    }

    public function actionSignup()
    {
        if(!Yii::$app->user->isGuest) {
            $this->redirect(['song/']);
        }

        $model = new RegisterForm();
        if ($model->load(\Yii::$app->request->post()) && $model->register())
        {
            $user = Users::findByUsername($model->username);
            Yii::$app->user->login($user);
            //var_dump(Yii::$app->user); die();
            return $this->goHome();
        }

        return $this->render('signup', ['model' => $model]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionUser($id)
    {
        $user = Users::find()->where(['id' => $id])->one();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $user->viewedSongs,
        ]);
        return $this->render('user', [
            'dataProvider' => $dataProvider,
            'user' => $user,
        ]);
    }

}
