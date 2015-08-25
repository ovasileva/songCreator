<?php
namespace app\controllers;
use Yii;
use app\models\Songs;
use app\models\Comments;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class SongController extends Controller
{
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
        $model_comments = new Comments();
        if ($model_comments->load(Yii::$app->request->post())) {
            if ($model_comments->save()) {
                $this->redirect(Url::toRoute(['song/view', 'id' => $id]));
            }
        }
        $model_comments->notice_id = $id;
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

    public function actionCreate()
    {
        $model = new Songs();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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
        Comments::deleteAll('notice_id = :id', [':id' => $id]);
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

    protected function findModel($id)
    {
        if (($model = Songs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}