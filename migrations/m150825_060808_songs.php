<?php

use yii\db\Schema;
use yii\db\Migration;

class m150825_060808_songs extends Migration
{
    public function up()
    {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('songs', [
            'id' => Schema::TYPE_INTEGER . "(11) AUTO_INCREMENT",
            'title' => Schema::TYPE_STRING . '(64) NOT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            'category_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'favorite' => Schema::TYPE_BOOLEAN . ' NOT NULL',
            'finished' => Schema::TYPE_BOOLEAN . ' NOT NULL',
            'PRIMARY KEY (id)',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('songs');
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
