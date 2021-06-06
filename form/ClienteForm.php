<?php

namespace app\form;
use Yii;
use yii\base\Model;

class ClienteForm extends Model {

    public $_id;
    public $name;

    public function rules() {
        return [
            [
                '_id', 
                'integer', 
                'message' => 'Id incorrecto'
            ],
            [
                'name', 
                'required', 
                'message' => 'Campo requerido'
            ],
            [
                'name', 
                'match', 
                'pattern' => '/^[a-záéíóúñ\s]+$/i', 
                'message' => 'Sólo es permitido letras'
            ],
            [
                'name', 
                'match', 
                'pattern' => '/^.{3,50}$/', 
                'message' => 'Mínimo 3 máximo 50 caracteres'
            ],
        ];
    }
    
    public function attributeLabels() {
        return [
            'clase'         => "Número de clase:",
            'num_documento' => "Número de documento:",
        ];
    }
}