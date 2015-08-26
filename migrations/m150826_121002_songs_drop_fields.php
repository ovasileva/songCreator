<?php

use yii\db\Schema;
use yii\db\Migration;

class m150826_121002_songs_drop_fields extends Migration
{
    public function up()
    {
        $this->db->createCommand('ALTER TABLE songs DROP `category_id`')->execute();
        $this->db->createCommand('ALTER TABLE songs DROP `favorite`')->execute();
        $this->db->createCommand('ALTER TABLE songs DROP `finished`')->execute();
    }

    public function down()
    {
        $this->addColumn('songs','category_id','integer');
        $this->addColumn('songs','favorite','boolean');
        $this->addColumn('songs','finished','boolean');
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
