<?php

namespace app\models;
use Yii;
use yii\mongodb\ActiveRecord;

class Cliente extends ActiveRecord {
    
    public static function getDb() {
        return Yii::$app->dbMongo;
    }
    
    public static function collectionName() {
        return 'client';
    }
    
    public function attributes() {
        return [
            '_id', 
            'name', 
            'company',
            'mobile'
        ];
    }

    public static function findAllClient() {
        
        $oClientes = Cliente::find()
                ->all();
        
        return isset($oClientes) ? new static($oClientes) : null;
    }

    public static function findById($id) {
        
        $cliente = Cliente::find()
                ->one();
        
        return isset($cliente) ? new static($cliente) : null;
    }
}