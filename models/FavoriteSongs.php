<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "favorite_songs".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $song_id
 */
class FavoriteSongs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'favorite_songs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['song_id'], 'required'],
            [['user_id', 'song_id'], 'integer'],
            [['created_at'], 'safe'],
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
            'created_at' => Yii::t('app', 'Created at'),
        ];
    }

    public function behaviors()
    {
        //behaviors
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ]
        ];
    }
}