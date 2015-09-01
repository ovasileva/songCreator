<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%songs_categories}}".
 *
 * @property integer $id
 * @property integer $song_id
 * @property integer $category_id
 *
 * @property Categories $category
 * @property Songs $song
 */
class SongsCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%songs_categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['song_id'], 'required'],
            [['song_id', 'category_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'song_id' => Yii::t('app', 'Song ID'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSong()
    {
        return $this->hasOne(Songs::className(), ['id' => 'song_id']);
    }
}
