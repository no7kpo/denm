<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "foto".
 *
 * @property string $idproducto
 * @property string $url
 *
 * @property Productos $idproducto0
 */
class Foto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idproducto', 'url'], 'required'],
            [['idproducto'], 'integer'],
            [['url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idproducto' => Yii::t('app', 'Idproducto'),
            'url' => Yii::t('app', 'Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdproducto0()
    {
        return $this->hasOne(Productos::className(), ['id' => 'idproducto']);
    }
}
