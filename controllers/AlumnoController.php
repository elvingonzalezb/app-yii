<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessController;
use yii\web\Controller;
use app\form\AlumnosForm;
use app\form\SearchForm;
use app\models\Alumnos;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\helpers\Url;

class AlumnoController extends Controller 
{
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionView() {     

        $searchForm = new SearchForm;
        $search = null;

        if($searchForm->load(Yii::$app->request->get())) {

            if (!$searchForm->validate()) {
                return $searchForm->getErrors();
            }

            $search  = Html::encode($searchForm->q);
            $alumnos = Alumnos::find()
                        ->where([
                            "like", 
                            "id_alumno", 
                            $search
                        ])
                        ->orWhere([
                            "like", 
                            "nombre", 
                            $search
                        ])
                        ->orWhere([
                            "like", 
                            "apellidos", 
                            $search
                        ]);
            $count = clone $alumnos;
            $pages = new Pagination([
                "pageSize"   => 1,
                "totalCount" => $count->count()
            ]);
            $oAlumnos = $alumnos
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();          
        } else {
            $alumnos = Alumnos::find();
            $count = clone $alumnos;
            $pages = new Pagination([
                "pageSize"   => 5,
                "totalCount" => $count->count(),
            ]);

            $oAlumnos = $alumnos
                    ->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
        }

        return $this->render("view", [
            "alumnos"    => $oAlumnos,
            "searchForm" => $searchForm, 
            "search"     => $search,
            "pages"      => $pages
        ]);
    }
    
    public function actionCreate() {
        $alumnosForm = new AlumnosForm;
        $desMensaje  = null;

        if($alumnosForm->load(Yii::$app->request->post())) {

            if(!$alumnosForm->validate()) { 
                return $alumnosForm->getErrors();
            }

            $alumno = new Alumnos;
            $alumno->nombre     = $alumnosForm->nombre;
            $alumno->apellidos  = $alumnosForm->apellidos;
            $alumno->clase      = $alumnosForm->clase;
            $alumno->nota_final = $alumnosForm->nota_final;

            if ($alumno->insert()) {
                $desMensaje = "Registro guardado correctamente";
                $alumnosForm->nombre     = null;
                $alumnosForm->apellidos  = null;
                $alumnosForm->clase      = null;
                $alumnosForm->nota_final = null;
            } else {
                $desMensaje = "Ha ocurrido un error al insertar el registro";
            }
        }
        return $this->render(
            "create", 
            [
                'alumnosForm' => $alumnosForm, 
                'desMensaje'  => $desMensaje]);
    }

    public function actionUpdate()
    {
        $alumnosForm = new AlumnosForm;
        $desMensaje  = null;
        
    
        if($alumnosForm->load(Yii::$app->request->post())) {

            if($alumnosForm->validate()) {

                $alumno = Alumnos::findOne($alumnosForm->id_alumno);

                if($alumno) {
                    $alumno->nombre     = $alumnosForm->nombre;
                    $alumno->apellidos  = $alumnosForm->apellidos;
                    $alumno->clase      = $alumnosForm->clase;
                    $alumno->nota_final = $alumnosForm->nota_final;

                    if ($alumno->update()) {
                        $msg = "El Alumno ha sido actualizado correctamente";
                        return $this->redirect(["alumno/view"]);
                    } else {
                        $msg = "El Alumno no ha podido ser actualizado";
                    }
                } else {
                    $msg = "El alumno seleccionado no ha sido encontrado";
                }
            } else {
                $alumnosForm->getErrors();
            }
        }

        
        if (!Yii::$app->request->get("id_alumno")) {
            return $this->redirect(["alumno/view"]);
        }

        $idAlumno = Html::encode($_GET["id_alumno"]);
        
        if (!(int) $idAlumno) {
            return $this->redirect(["alumno/view"]);
        }

        $alumnoEdit = Alumnos::findOne($idAlumno);

        if (!$alumnoEdit) {
            return $this->redirect(["alumno/view"]);
        }

        $alumnosForm->id_alumno  = $alumnoEdit->id_alumno;
        $alumnosForm->nombre     = $alumnoEdit->nombre;
        $alumnosForm->apellidos  = $alumnoEdit->apellidos;
        $alumnosForm->clase      = $alumnoEdit->clase;
        $alumnosForm->nota_final = $alumnoEdit->nota_final;      

        return $this->render("update", [
            "alumnosForm" => $alumnosForm, 
            "desMensaje"  => $desMensaje
        ]);
    }
    

    public function actionDelete()
    {
        if(!Yii::$app->request->post()) {
            return $this->redirect(["alumno/view"]);
        }

        $id_alumno = Html::encode($_POST["id_alumno"]);

        if(!(int) $id_alumno) {
            echo "Ha ocurrido un error al eliminar el alumno, redireccionando ...";
            echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("alumno/view")."'>";
        }

        if(Alumnos::deleteAll("id_alumno = :id_alumno", [":id_alumno" => $id_alumno])) {
            echo "Alumno con id $id_alumno eliminado con éxito, redireccionando ...";
            echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("alumno/view")."'>";
        } else {
            echo "Ha ocurrido un error al eliminar el alumno, redireccionando ...";
            echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("alumno/view")."'>"; 
        }       
    }
}

?>