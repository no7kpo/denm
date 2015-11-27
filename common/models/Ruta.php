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
            [['id', 'idcomercio', 'relevado','dia'], 'integer']
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
}