<?php

namespace app\form;
use Yii;
use yii\base\Model;

class SearchForm extends Model {

    public $q;             
    
    public function rules() {
        return [
            [
                "q", 
                "match", 
                "pattern" => "/^[0-9a-záéíóúñ\s]+$/i", 
                "message" => "Sólo se aceptan letras y números"
            ]
        ];
    }
    
    public function attributeLabels() {
        return [
            'q' => "Buscar:",
        ];
    }
}