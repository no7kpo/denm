<?php

use yii\db\Schema;
use yii\db\Migration;

class m151129_223546_fecha_add_ruta extends Migration
{
    public function up()
    {
        $this->addColumn('{{%ruta}}','fecha','date');
    }

    public function down()
    {
        echo "m151129_223546_fecha_add_ruta cannot be reverted.\n";

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
