<?php

namespace app\models;
use Yii;
use yii\data\ActiveDataProvider;

class UsersSearch extends \yii\base\Model
{
    public $fullName;

    public function rules() {
        return [
            [['fullName'], 'safe']
        ];
    }

    public function search($params) {
        $query = Users::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10]
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'fullName' => [
                    'asc' => ['username' => SORT_ASC, 'first_name' => SORT_ASC, 'last_name' => SORT_ASC, ],
                    'desc' => ['username' => SORT_DESC, 'first_name' => SORT_DESC, 'last_name' => SORT_DESC, ],
                    'default' => SORT_ASC
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andWhere('first_name LIKE "%' . $this->fullName . '%" ' .
            'OR last_name LIKE "%' . $this->fullName . '%" ' .
            'OR username LIKE "%' . $this->fullName . '%" '
        );

        return $dataProvider;
    }
}