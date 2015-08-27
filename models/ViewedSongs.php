<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "viewed_songs".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $song_id
 */
class ViewedSongs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'viewed_songs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'song_id'], 'required'],
            [['user_id', 'song_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'song_id' => Yii::t('app', 'Song ID'),
        ];
    }
}