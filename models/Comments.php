<?php
namespace app\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $text
 * @property string $created_at
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    public function rules()
    {
        return [
            [['text'], 'required'],
            [['author_id', 'song_id'], 'integer'],
            [['text'], 'string'],
            [['created_at'], 'safe']
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
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => false,
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'text' => 'Text',
            'song_id' => 'Song ID',
            'created_at' => 'Created At',
        ];
    }
    public function getAuthor()
    {
        //getAuthor
        return $this->hasOne(Users::className(), ['id' => 'author_id']);
    }
}