<?php

use yii\db\Schema;
use yii\db\Migration;

class m150826_120230_viewed_songs extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('viewed_songs', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'song_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('viewed_songs');
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
