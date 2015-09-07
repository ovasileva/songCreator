<?php

use yii\db\Schema;
use yii\db\Migration;

class m150907_095815_favorite_vieved_datetime extends Migration
{
    public function up()
    {
        $this->db->createCommand('ALTER TABLE favorite_songs CHANGE `created_at` `created_at` datetime ')->execute();
        $this->db->createCommand('ALTER TABLE viewed_songs CHANGE `created_at` `created_at` datetime ')->execute();
    }

    public function down()
    {
        $this->db->createCommand('ALTER TABLE favorite_songs CHANGE `created_at` `created_at` DATE ')->execute();
        $this->db->createCommand('ALTER TABLE viewed_songs CHANGE `created_at` `created_at` DATE ')->execute();
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
