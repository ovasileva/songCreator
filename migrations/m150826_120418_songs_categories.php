<?php

use yii\db\Schema;
use yii\db\Migration;

class m150826_120418_songs_categories extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('songs_categories', [
            'id' => Schema::TYPE_PK,
            'song_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'category_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('songs_categories');
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
