<?php

use yii\db\Schema;
use yii\db\Migration;

class m151123_224300_cambio_ruta extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%ruta}}','fecha');
        $this->addColumn('{{%ruta}}','dia','integer');
    }

    public function down()
    {
        echo "m151123_224300_new_user cannot be reverted.\n";

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
