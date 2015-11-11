<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload()
    {
        $directory = Yii::getAlias('@backend') . '/imagenes/productos';
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }    
            
        if ($this->validate()) {
            $file_name = date('Y-m-d H:i:s') . "_" . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($directory . '/' . $file_name);
            /*$foto = new Foto();
                $foto->idproducto = $id;
                $foto->url = $file_name;
                $foto->save();*/
            return $file_name;
        } else {  
            return false;
        }
    }
}
?>