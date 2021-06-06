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
    
        if ($model->load(Yii::$app->request->post()) 
            && Yii::$app->request->isAjax
        ) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            if($model->validate()) {
            
                $tableUsers = new Users;
                $tableUsers->username = $model->username;
                $tableUsers->email    = $model->email;            
                $tableUsers->password = crypt($model->password, Yii::$app->params["salt"]);
                $tableUsers->authKey  = $this->randKey("abcdef0123456789", 200);
            
                $tableUsers->accessToken = $this->randKey("abcdef0123456789", 200);
                    
            
                if ($tableUsers->insert()) {
                    
                    $user    = $tableUsers->find()->where(["email" => $model->email])->one();
                    $id      = urlencode($user->id);
                    $authKey = urlencode($user->authKey);
                            
                    $model->username        = null;
                    $model->email           = null;
                    $model->password        = null;
                    $model->password_repeat = null;
                    
                    $desMensaje = "Registro satisfactorio";
                }         
            }           
        }

        return $this->render("register", [
            "userModel"  => $model, 
            "desMensaje" => $desMensaje
        ]);
    }
}
