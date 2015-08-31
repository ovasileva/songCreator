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
use app\models\Categories;
use app\models\SongsCategories;

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
        $query = Songs::find()->where('')->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $query,
            'key' => 'id',
        ]);

        $model = new SongsCategories();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        if (!ViewedSongs::find()->where(['song_id' => $id])->andWhere(['user_id' => Yii::$app->user->identity->id])->one()) {
            $viewed_song = new ViewedSongs();
            // $viewed_song->user_id = Yii::$app->user->id; (fill in model)
            $viewed_song->song_id = $id;
            $viewed_song->save();
        }

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

    public function actionAddfavorite($id)
    {
        $favorite_song = new FavoriteSongs();
        //$favorite_song->user_id = Yii::$app->user->id; (fill in model)
        $favorite_song->song_id = $id;
        $favorite_song->save();

        return $this->redirect(['song/view', 'id' => $id]);
    }

    public function actionDeletefavorite($id)
    {
        $favorite_song = FavoriteSongs::find()->where(['song_id' => $id])->andWhere(['user_id' => Yii::$app->user->identity->id])->one();
        $favorite_song->delete();

        return $this->redirect(['song/view', 'id' => $id]);
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
        $song = new Songs();
        $category = new Categories();

        if ($category->load(Yii::$app->request->post()) && $category->save())
        {
            return $this->redirect(['settings']);
        }

        if ($song->load(Yii::$app->request->post()) && $song->save()) {
            foreach (Yii::$app->request->post()['Songs']['songsCategories'] as $category_id) {
                $song_category = new SongsCategories();
                $song_category->song_id = $song->id;
                $song_category->category_id = $category_id;
                $song_category->save();
            }
            return $this->redirect(['view', 'id' => $song->id]);

        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Users::find(),
                'key' => 'username',
            ]);
            return $this->render('settings', [
                'song' => $song,
                'category' => $category,
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