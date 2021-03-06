<?php
namespace app\controllers;
use Yii;
use app\models\Songs;
use app\models\Comments;
use app\models\UsersSearch;
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
use app\models\Users;
use app\models\SongsSearch;

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
                        'actions' => ['index', 'deletecomment', 'view', 'favorites', 'addfavorite', 'deletefavorite'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
            $model = new SongsCategories();
            if (Yii::$app->request->post() != [] && Yii::$app->request->post()['SongsCategories']['category_id'] != '') {
                $model->category_id = Yii::$app->request->post()['SongsCategories']['category_id'];
                $category = Categories::find()->where(['id' => Yii::$app->request->post()['SongsCategories']['category_id']])->one();
                $songs = $category->songs;
            }
            else {
                $songs = Songs::find()->all();
            }

            $dataProvider = new ArrayDataProvider([
                'allModels' => $songs,
                'pagination' => ['pageSize' => 10],
            ]);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]);
    }

    public function actionView($id)
    {
        if (!ViewedSongs::find()->where(['song_id' => $id])->andWhere(['user_id' => Yii::$app->user->identity->id])->one()) {
            $viewed_song = new ViewedSongs();
            $viewed_song->song_id = $id;
            $viewed_song->save(); //field 'user_id' is filled in model
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
        $favorite_song->song_id = $id;
        $favorite_song->save(); //field 'user_id' is filled in model

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
        $song = $this->findModel($id);
        if ($song->load(Yii::$app->request->post()) && $song->save()) {
            SongsCategories::deleteAll('song_id = :id', [':id' => $id]);
            foreach (Yii::$app->request->post()['Songs']['categories'] as $category_id) {
                $song_category = new SongsCategories();
                $song_category->song_id = $song->id;
                $song_category->category_id = $category_id;
                $song_category->save();
            }
            return $this->redirect(['view', 'id' => $song->id]);
        } else {
            return $this->render('update', [
                'song' => $song,
            ]);
        }
    }

    public function actionDelete($id)
    {
        Comments::deleteAll('song_id = :id', [':id' => $id]);
        ViewedSongs::deleteAll('song_id = :id', [':id' => $id]);
        FavoriteSongs::deleteAll('song_id = :id', [':id' => $id]);
        SongsCategories::deleteAll('song_id = :id', [':id' => $id]);
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
            foreach (Yii::$app->request->post()['Songs']['categories'] as $category_id) {
                $song_category = new SongsCategories();
                $song_category->song_id = $song->id;
                $song_category->category_id = $category_id;
                $song_category->save();
            }
            return $this->redirect(['view', 'id' => $song->id]);

        } else {
            $searchModel = new UsersSearch();
            $dataProvider = $searchModel->search((Yii::$app->request->get()));

            return $this->render('settings', [
                'song' => $song,
                'category' => $category,
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);
        }
    }

    public function actionFavorites($user_id)
    {
        $user = Users::find()->where(['id' => $user_id])->one();
        $searchModel = new SongsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get(), $user->getFavoriteSongs());

        return $this->render('favorites', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'user' => $user,
        ]);
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