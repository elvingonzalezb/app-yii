<?php

namespace app\form;
use Yii;
use yii\base\Model;
use app\models\Users;

class UserForm extends Model {

    public $username;
    public $email;
    public $password;
    public $password_repeat;            
    
    public function rules() {
        return [
            [[
                'username', 'email', 'password', 'password_repeat'
            ], 
                'required', 
                'message' => 'Campo requerido'
            ],
            [
                'username', 
                'match', 
                'pattern' => "/^.{3,50}$/", 
                'message' => 'Mínimo 3 y máximo 50 caracteres'
            ],
            [
                'username', 
                'match', 
                'pattern' => "/^[0-9a-z]+$/i", 
                'message' => 'Sólo se aceptan letras y números'
            ],
            [
                'username', 
                'existsUsername'
            ],
            [
                'email', 
                'match', 
                'pattern' => "/^.{5,80}$/", 
                'message' => 'Mínimo 5 y máximo 80 caracteres'
            ],
            [
                'email', 
                'email', 
                'message' => 'Formato no válido'
            ],
            [
                'email', 
                'existEmail'
            ],
            [
                'password', 
                'match', 
                'pattern' => "/^.{8,16}$/", 
                'message' => 'Mínimo 6 y máximo 16 caracteres'
            ],
            [
                'password_repeat', 
                'compare', 
                'compareAttribute' => 'password', 
                'message'          => 'Los passwords no coinciden'
            ],
        ];
    }

    public function existEmail($attribute, $params) {
        $email = Users::find()->where("email = :email", [
                ":email" => $this->email
            ]);

        if ($email->count() == 1) {
            $this->addError($attribute, "El email seleccionado existe");
        }
    }

    public function existsUsername($attribute, $params) {
        $username = Users::find()->where("username = :username", [
                ":username" => $this->username
            ]);
        
        if ($username->count() == 1) {
            $this->addError($attribute, "El usuario seleccionado existe");
        }
    }

}