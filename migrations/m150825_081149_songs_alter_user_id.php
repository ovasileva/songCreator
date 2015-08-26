<?php

use yii\db\Schema;
use yii\db\Migration;

class m150825_081149_songs_alter_user_id extends Migration
{
    public function up()
    {
        $this->db->createCommand('ALTER TABLE songs CHANGE `user_id` `author_id` INTEGER')->execute();
    }

    public function down()
    {
        $this->db->createCommand('ALTER TABLE songs CHANGE `author_id` `user_id` INTEGER')->execute();
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
