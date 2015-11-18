<?php
use yii\db\Schema;
use yii\db\Migration;
class m151118_202256_modificacion_tablas extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
          $this->addColumn('{{%user}}','latitud','string');
        $this->addColumn('{{%user}}','longitud','string');
        $this->addColumn('{{%comercios}}','dia','integer');
        $this->dropTable('{{%ruta_comercio}}');
        $this->dropTable('{{%rutas}}');
        $this->createTable('{{%ruta}}', [
           'id' => 'bigint NOT NULL',
            'idcomercio' => 'bigint NOT NULL',
            'relevado' => 'tinyint default 0',
            'fecha' => 'date NOT NULL'
        ], $tableOptions);
        $this->createIndex('idcomercio_index', '{{%ruta}}', 'idcomercio', true);
         $this->addForeignKey('fk_idcomercio_ruta_comercio', '{{%ruta}}', 'idcomercio', '{{%comercios}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createTable('{{%ruta_relevador}}', [
            'idruta' => 'bigint NOT NULL',
            'idrelevador' => 'int NOT NULL'
        ], $tableOptions);
        $this->createIndex('idrelevador_index', '{{%ruta_relevador}}', 'idrelevador', true);
         $this->addForeignKey('fk_idrelevador_relevador', '{{%ruta_relevador}}', 'idrelevador', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('idruta_index', '{{%ruta_relevador}}', 'idruta', true);
        $this->addPrimaryKey ( 'ruta_pk','{{%ruta}}' , 'id' );
        $this->addPrimaryKey ( 'ruta_pk_relevador','{{%ruta}}' , ['idruta','idrelevador' ]);
         $this->addForeignKey('fk_idruta_ruta', '{{%ruta_relevador}}', 'idruta', '{{%ruta}}', 'id', 'CASCADE', 'RESTRICT');
    }
    public function down()
    {
        echo "m151118_202256_modificacion_tablas cannot be reverted.\n";
        return true;
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