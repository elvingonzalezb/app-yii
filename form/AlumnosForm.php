<?php

namespace app\form;
use Yii;
use yii\base\Model;

class AlumnosForm extends Model {

    public $id_alumno;
    public $nombre;
    public $apellidos;
    public $clase;
    public $num_documento;

    public function rules() {
        return [
            [
                'id_alumno', 
                'integer', 
                'message' => 'Id incorrecto'
            ],
            [
                'nombre', 
                'required', 
                'message' => 'Campo requerido'
            ],
            [
                'nombre', 
                'match', 
                'pattern' => '/^[a-záéíóúñ\s]+$/i', 
                'message' => 'Sólo es permitido letras'
            ],
            [
                'nombre', 
                'match', 
                'pattern' => '/^.{3,50}$/', 
                'message' => 'Mínimo 3 máximo 50 caracteres'
            ],
            [
                'apellidos', 
                'required', 
                'message' => 'Campo requerido'
            ],
            [
                'apellidos', 
                'match', 
                'pattern' => '/^[a-záéíóúñ\s]+$/i', 
                'message' => 'Sólo es permitido letras'
            ],
            [
                'apellidos', 
                'match', 
                'pattern' => '/^.{3,80}$/', 
                'message' => 'Mínimo 3 máximo 80 caracteres'
            ],
            [
                'clase', 
                'required', 
                'message' => 'Campo requerido'
            ],
            [
                'clase', 
                'integer', 
                'message' => 'Sólo números enteros'
            ],
            [
                'num_documento', 
                'required', 
                'message' => 'Campo requerido'
            ],
            [
                'num_documento', 
                'number', 
                'message' => 'Sólo números'
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