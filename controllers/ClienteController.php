<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessController;
use yii\web\Controller;
use app\form\ClienteForm;
use app\models\Cliente;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\helpers\Url;

class ClienteController extends Controller 
{
    public function actionIndex() {

        $table     = new Cliente;
        $oClientes = $table->findAllClient();

        return $this->render("index", [
            "clientes" => $oClientes
        ]);
    }

}

?>