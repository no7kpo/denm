<?php

namespace common\models;
use dektrium\user\models\User as BaseUser;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property integer $confirmed_at
 * @property string $unconfirmed_email
 * @property integer $blocked_at
 * @property string $registration_ip
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $flags
 * @property string $latitud
 * @property string $longitud
 *
 * @property Profile $profile
 * @property RutaRelevador $rutaRelevador
 * @property Ruta[] $idrutas
 * @property SocialAccount[] $socialAccounts
 * @property Token[] $tokens
 */
class User extends BaseUser
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['latitud', 'longitud'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'latitud' => Yii::t('app', 'Latitude'),
            'longitud' => Yii::t('app', 'Longitude'),
        ];
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutaRelevador()
    {
        return $this->hasOne(RutaRelevador::className(), ['idrelevador' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdrutas()
    {
        return $this->hasMany(Ruta::className(), ['id' => 'idruta'])->viaTable('ruta_relevador', ['idrelevador' => 'id']);
    }
    
}
