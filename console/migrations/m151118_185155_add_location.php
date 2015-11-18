<?php

use yii\db\Schema;
use yii\db\Migration;

class m151118_185155_add_location extends Migration
{
    public function up()
    {
        $this->addColumn('{{%ruta_comercio}}','relevado','boolean');
        $this->addColumn('{{%comercios}}','direccion','string');
    }

    public function down()
    {
        echo "m151118_185155_add_location cannot be reverted.\n";

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
