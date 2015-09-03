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
            //return $this->goHome();
            return $this->redirect(['index']);
        }

        return $this->render('signup', ['model' => $model]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            //return $this->goHome();
            return $this->redirect(['index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            return $this->redirect(['index']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        //return $this->goHome();
        return $this->redirect(['index']);
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
