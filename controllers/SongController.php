<?php
namespace app\controllers;
use Yii;
use app\models\Songs;
use app\models\Comments;
use app\models\Users;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\models\ViewedSongs;
use app\models\FavoriteSongs;

class SongController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'deletecomment', 'view'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Songs::find()->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $query,
            'key' => 'id',
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $viewed_song = new ViewedSongs();
        $viewed_song->user_id = Yii::$app->user->id;
        $viewed_song->song_id = $id;
        $viewed_song->save();

        $model_comments = new Comments();
        if ($model_comments->load(Yii::$app->request->post())) {
            if ($model_comments->save()) {
                $this->redirect(Url::toRoute(['song/view', 'id' => $id]));
            }
        }
        $model_comments->song_id = $id;
        $dataProvider = new ActiveDataProvider([
            'query' => Comments::find()->where(['song_id' => $id]),
            'key' => 'id',
        ]);
        return $this->render('view', [
            'model_comments' => $model_comments,
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
        ]);
    }

    public function actionFavorite($id)
    {
        $favorite_song = new FavoriteSongs();
        $favorite_song->user_id = Yii::$app->user->id;
        $favorite_song->song_id = $id;
        $favorite_song->save();
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        Comments::deleteAll('song_id = :id', [':id' => $id]);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionDeletecomment($id_comment)
    {
        $comment = Comments::findOne($id_comment);
        $song_id = $comment->song_id;
        $comment->delete();
        return $this->redirect(Url::toRoute(['song/view', 'id' => $song_id]));
    }

    public function actionSettings()
    {
        $model = new Songs();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Users::find(),
                'key' => 'username',
            ]);
            return $this->render('settings', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Songs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}