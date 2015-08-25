<?php

use yii\db\Schema;
use yii\db\Migration;

class m150825_074017_users_auth_token extends Migration
{public function up()
{
    $this->addColumn('users','authKey','text');
    $this->addColumn('users','accessToken','text');
    return;
}
    public function down()
    {
        $this->dropColumn('users','authKey');
        $this->dropColumn('users','accessToken');
        return false;
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
