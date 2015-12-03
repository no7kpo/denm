<?php

use yii\db\Schema;
use yii\db\Migration;

class m151202_221100_fix_hora extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%comercios}}','hora_apertura');
        $this->addColumn('{{%comercios}}','hora_apertura','time');
        $this->dropColumn('{{%comercios}}','hora_cierre');
        $this->addColumn('{{%comercios}}','hora_cierre','time');
    }

    public function down()
    {
        echo "m151202_221100_fix_hora cannot be reverted.\n";

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
