<?php
namespace app\models;

class UsersQuery extends \yii\db\ActiveQuery
{
    public function byPk($itemId)
    {
        $this->andWhere('id=:itemId')
            ->addParams([':itemId' => $itemId]);
        return $this;
    }

    public function all($db = null)
    {
        return parent::all($db);
    }

    public function one($db = null)
    {
        return parent::one($db);
    }
}