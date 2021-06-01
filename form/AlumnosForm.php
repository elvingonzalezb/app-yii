<?php

namespace app\form;
use Yii;
use yii\base\model;

class AlumnosForm extends model {

    public $id_alumno;
    public $nombre;
    public $apellidos;
    public $clase;
    public $nota_final;

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
                'nota_final', 
                'required', 
                'message' => 'Campo requerido'
            ],
            [
                'nota_final', 
                'number', 
                'message' => 'Sólo números'
            ],
        ];
    } 
}