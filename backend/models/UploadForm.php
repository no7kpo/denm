<?php
namespace backend\models;

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
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload($id)
    {
        var_dump($this->validate());
        
        if ($this->validate()) {

            $this->imageFile->saveAs('assets/imgOfertas/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $foto = new Foto();
                $foto->idproducto = $id;
                $foto->url = $file_name;
                $foto->save();
            return true;
        } else {
            
            return false;
        }
    }
}
?>