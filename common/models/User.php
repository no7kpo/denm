<?php

namespace common\models;
use dektrium\user\models\User as BaseUser;

use dektrium\user\helpers\Password;
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
class User extends BaseUser implements \OAuth2\Storage\UserCredentialsInterface
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
    
    // public static function findIdentityByAccessToken($token, $type = null)
    // {
    //     /** @var \filsh\yii2\oauth2server\Module $module */
    //     $module = Yii::$app->getModule('oauth2');
    //     $token = $module->getServer()->getResourceController()->getToken();

    //     return !empty($token['user_id'])
    //                 ? static::findIdentity($token['user_id'])
    //                 : null;
    // }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $storage = new \filsh\yii2\oauth2server\storage\Pdo(null,array());
        $accessToken = $storage->getAccessToken($token);
        if (($accessToken['expires'] - time()) > 0) {
            $user_id = $accessToken['user_id'];
            return static::findOne($user_id);
        }
        return static::findOne(["api_key" => $token]);
    }

    public function checkUserCredentials($username, $password)
    {
        $user = static::findByUsername($username);
        if (empty($user)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    public function getUserDetails($username)
    {
        $user = static::findByUsername($username);
        if ($user === null) {
            return false;
        }
        return ['user_id' => $user->id];
    }

    public static function findByUsername($username){
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
