<?php

use yii\db\Schema;
use yii\db\Migration;

class m150825_060230_users extends Migration
{
    public function up()
    {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('users', [
            'id' => Schema::TYPE_INTEGER. "(11) AUTO_INCREMENT",
            'username' => Schema::TYPE_STRING. '(64) NOT NULL',
            'password' => Schema::TYPE_STRING. '(64) NOT NULL',
            'first_name' => Schema::TYPE_STRING. '(64) NOT NULL',
            'last_name' => Schema::TYPE_STRING. '(64) NOT NULL',
            'email' => Schema::TYPE_STRING. '(64) NOT NULL',
            'PRIMARY KEY (id)',
        ], $tableOptions);
    }
    public function down()
    {
        $this->dropTable('users');
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
