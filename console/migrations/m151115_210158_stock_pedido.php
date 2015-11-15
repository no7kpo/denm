<?php

use yii\db\Schema;
use yii\db\Migration;

class m151115_210158_stock_pedido extends Migration
{
   public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%stock_pedido}}', [
            'idcomercio' => 'bigint NOT NULL',
            'idproducto' => 'bigint NOT NULL',
            'stock' => $this->integer()->notNull(),
            'pedido' => $this->integer()->notNull(),
            'fecha' => 'date NOT NULL'
        ], $tableOptions);
        $this->createIndex('idcomercio_index', '{{%stock_pedido}}', 'idcomercio', true);
        $this->createIndex('idproducto_index', '{{%stock_pedido}}', 'idproducto', true);
        $this->addPrimaryKey ( 'stock_pedido_pk','{{%stock_pedido}}' , ['idcomercio','idproducto','fecha'] );
         $this->addForeignKey('fk_idcomercio_comercio', '{{%stock_pedido}}', 'idcomercio', '{{%comercios}}', 'id', 'CASCADE', 'RESTRICT');
         $this->addForeignKey('fk_idproducto_producto', '{{%stock_pedido}}', 'idproducto', '{{%productos}}', 'id', 'CASCADE', 'RESTRICT');
    }

     
    public function down()
    {
        $this->dropTable('{{%stock_pedido}}');
    }
}
