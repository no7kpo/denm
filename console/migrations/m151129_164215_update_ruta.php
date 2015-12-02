<?php

use yii\db\Schema;
use yii\db\Migration;

class m151129_164215_update_ruta extends Migration
{
    public function up()
    {
         $this->addColumn('{{%ruta}}','activa','boolean');
    }

    public function down()
    {
        echo "m151129_164215_update_ruta cannot be reverted.\n";

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
