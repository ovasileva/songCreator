<?php

use yii\db\Schema;
use yii\db\Migration;

class m150825_061549_comments extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('comments', [
            'id' => Schema::TYPE_PK,
            'author_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            'song_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('comments');
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
