<?php
namespace app\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;

class Songs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'songs';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['text'], 'string'],
            [['created_at'], 'safe'],
            [['author_id'], 'integer'],
            [['title'], 'string', 'max' => 100],
        ];
    }
    public function behaviors()
    {
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
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'created_at' => 'Created At',
            'author_id' => 'Author ID',
        ];
    }
    public function getAuthor()
    {
        return $this->hasOne(Users::className(), ['id' => 'author_id']);
    }

    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])->viaTable('songs_categories', ['song_id' => 'id'])->all();
    }
}