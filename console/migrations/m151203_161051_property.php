<?php

use yii\db\Schema;
use yii\db\Migration;

class m151203_161051_property extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%propiedades}}', [
           'id' => 'string NOT NULL',
            'valor' => 'string NOT NULL'
        ], $tableOptions);
        $this->insert('propiedades',array(
         'id'=>'distancia',
         'valor' =>'50000'
  ));
    }

    public function down()
    {
        echo "m151203_161051_property cannot be reverted.\n";

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
