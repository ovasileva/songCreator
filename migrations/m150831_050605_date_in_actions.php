<?php

use yii\db\Schema;
use yii\db\Migration;

class m150831_050605_date_in_actions extends Migration
{
    public function up()
    {
        $this->addColumn('viewed_songs','created_at','date');
        $this->addColumn('favorite_songs','created_at','date');
    }

    public function down()
    {
        $this->dropColumn('viewed_songs','created_at');
        $this->dropColumn('favorite_songs','created_at');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
