<?php

use yii\db\Schema;
use yii\db\Migration;

class m151123_224300_new_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%userdir}}', [
           'iduser' => 'int NOT NULL',
            'latitud' => $this->string(),
            'longitud' => $this->string()
        ], $tableOptions);
        $this->addForeignKey('fk_userdir_user', '{{%userdir}}', 'iduser', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->dropColumn('{{%user}}','latitud');
        $this->dropColumn('{{%user}}','longitud');
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
