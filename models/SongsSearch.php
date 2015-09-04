<?php

namespace app\models;
use Yii;
use yii\data\ActiveDataProvider;

class SongsSearch extends \yii\base\Model
{
    public $title;

    /* Настройка правил */
    public function rules() {
        return [
            /* your other rules */
            [['title'], 'safe']
        ];
    }

    /**
     * Настроим поиск для использования
     * поля fullName
     */
    public function search($params, $user) {
        $query = $user->getViewedSongs();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20]
        ]);

        /**
         * Настройка параметров сортировки
         * Важно: должна быть выполнена раньше $this->load($params)
         */
        $dataProvider->setSort([
            'attributes' => [
                'viewedSongs' => [
                    'asc' => ['title' => SORT_ASC],
                    'desc' => ['title' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        /* Настроим правила фильтрации */

        $query->andWhere('title LIKE "%' . $this->title . '%" ');

        return $dataProvider;
    }
}