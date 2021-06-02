<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessController;
use yii\web\Controller;
use app\form\UserForm;
use app\models\Users;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Response;
use kartik\widgets\ActiveForm;


class UserController extends Controller 
{
    public function actionIndex() {
        return $this->render('index');
    }

    private function randKey($str='', $long = 0) {
        $key   = null;
        $str   = str_split($str);
        $start = 0;
        $limit = count($str)-1;

        for($x = 0; $x <$long; $x++) {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }

    public function actionConfirm() {
        $tableUsers = new Users;

        if (Yii::$app->request->get()) {  

            $id = Html::encode($_GET["id"]);
            $authKey = $_GET["authKey"];
        
            if ((int) $id) {
            
                $oUser = $tableUsers
                    ->find()
                    ->where("id = :id", [":id" => $id])
                    ->andWhere("authKey=:authKey", [":authKey" => $authKey]);
        
                if ($oUser->count() == 1) {
                    $user = Users::findOne($id);
                    $user->is_activate = 1;

                    if ($user->update()) {
                        Url::toRoute("site/login");
                    } 
                }           
            }
        }
    }

    public function actionRegister() {
        
        $model      = new UserForm;
        $desMensaje = null;

        //Validación mediante ajax
        if ($model->load(Yii::$app->request->post()) 
            && Yii::$app->request->isAjax
        ) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        //Validación cuando el formulario es enviado vía post
        //Esto sucede cuando la validación ajax se ha llevado a cabo correctamente
        //También previene por si el usuario tiene desactivado javascript y la
        //validación mediante ajax no puede ser llevada a cabo
        if ($model->load(Yii::$app->request->post())) {

            if($model->validate()) {
            
                $tableUsers = new Users;
                $tableUsers->username = $model->username;
                $tableUsers->email    = $model->email;
            
                $tableUsers->password = crypt($model->password, Yii::$app->params["salt"]);
                //Creamos una cookie para autenticar al usuario cuando decida recordar la sesión, esta misma
                //clave será utilizada para activar el usuario
                $tableUsers->authKey = $this->randKey("abcdef0123456789", 200);
                //Creamos un token de acceso único para el usuario
                $tableUsers->accessToken = $this->randKey("abcdef0123456789", 200);
                    
                //Si el registro es guardado correctamente
                if ($tableUsers->insert()) {
                    //Nueva consulta para obtener el id del usuario
                    //Para confirmar al usuario se requiere su id y su authKey
                    $user    = $tableUsers->find()->where(["email" => $model->email])->one();
                    $id      = urlencode($user->id);
                    $authKey = urlencode($user->authKey);
                
                    $subject = "Confirmar registro";
                    $body = "<h1>Haga click en el siguiente enlace para finalizar tu registro</h1>";
                    $body .= "<a href='http://yii.local/index.php?r=site/confirm&id=".$id."&authKey=".$authKey."'>Confirmar</a>";
                
                    //Enviamos el correo
                    Yii::$app->mailer->compose()
                        ->setTo($user->email)
                        ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                        ->setSubject($subject)
                        ->setHtmlBody($body)
                        ->send();
                    
                    $model->username = null;
                    $model->email = null;
                    $model->password = null;
                    $model->password_repeat = null;
                    
                    $desMensaje = "Por favor confirma tu registro en tu cuenta de correo";
                } else {
                    $desMensaje = "Ha ocurrido un error al llevar a cabo tu registro";
                }         
            }           
        }

        return $this->render("register", [
            "userModel"  => $model, 
            "desMensaje" => $desMensaje
        ]);
    }
}
