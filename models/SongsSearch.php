<?php

namespace app\models;
use Yii;
use yii\data\ActiveDataProvider;

class SongsSearch extends \yii\base\Model
{
    public $title;

    public function rules() {
        return [
            [['title'], 'safe']
        ];
    }

    public function search($params, $query) {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20]
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'title' => [
                    'asc' => ['title' => SORT_ASC],
                    'desc' => ['title' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'created_at',
            ]
        ]);


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andWhere('title LIKE "%' . $this->title . '%" ');

        return $dataProvider;
    }
}