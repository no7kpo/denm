<?php
namespace common\models;
use Yii;
/**
 * This is the model class for table "ruta".
 *
 * @property string $id
 * @property string $idcomercio
 * @property integer $relevado
 * @property string $fecha
 * @property integer $dia
 * @property integer $activa
 *
 * @property Comercios $idcomercio0
 * @property RutaRelevador[] $rutaRelevadors
 * @property User[] $idrelevadors
 */
class Ruta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ruta';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idcomercio'], 'required'],
            [['id', 'idcomercio', 'relevado','dia','activa'], 'integer']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'idcomercio' => Yii::t('app', 'Shop'),
            'relevado' => Yii::t('app', 'Relevated'),
            'dia' => Yii::t('app', 'Day of week'),
            'activa' => Yii::t('app', 'Is active')
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcomercio0()
    {
        return $this->hasOne(Comercios::className(), ['id' => 'idcomercio']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutaRelevadors()
    {
        return $this->hasMany(RutaRelevador::className(), ['idruta' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdrelevadors()
    {
        return $this->hasMany(User::className(), ['id' => 'idrelevador'])->viaTable('ruta_relevador', ['idruta' => 'id']);
    }
           public function getDia(){
        if($this->dia == '0') return Yii::t('app','Monday');
        if($this->dia == '1') return Yii::t('app','Tuesday');
        if($this->dia == '2') return Yii::t('app','Wednesday');
        if($this->dia == '3') return Yii::t('app','Thursday');
        if($this->dia == '4') return Yii::t('app','Friday');
        if($this->dia == '5') return Yii::t('app','Saturday');
    }
}