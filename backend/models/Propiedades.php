<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "propiedades".
 *
 * @property string $id
 * @property string $valor
 */
class Propiedades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'propiedades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'valor'], 'required'],
            [['id', 'valor'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'valor' => Yii::t('app', 'The maximun distance to travel at the momment is :'),
        ];
    }
}
