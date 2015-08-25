<?php

use yii\db\Schema;
use yii\db\Migration;

class m150825_061900_categories extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('categories', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
        ], $tableOptions);


    }

    public function down()
    {
        $this->dropTable('categories');
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
