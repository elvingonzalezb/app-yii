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

        if ($alumnosForm->load(Yii::$app->request->post())) {

            if ($alumnosForm->validate()) { 

                $alumno = new Alumnos;
                $alumno->nombre        = $alumnosForm->nombre;
                $alumno->apellidos     = $alumnosForm->apellidos;
                $alumno->clase         = $alumnosForm->clase;
                $alumno->num_documento = $alumnosForm->num_documento;

                if ($alumno->insert()) {
                    $desMensaje = "Registro guardado correctamente";
                    $alumnosForm->nombre        = null;
                    $alumnosForm->apellidos     = null;
                    $alumnosForm->clase         = null;
                    $alumnosForm->num_documento = null;
                } else {
                    $desMensaje = "Ha ocurrido un error al insertar el registro";
                }
            }            
        }
        return $this->render(
            "create", [
                'alumnosForm' => $alumnosForm, 
                'desMensaje'  => $desMensaje
            ]);
    }

    public function actionUpdate() {
        $alumnosForm = new AlumnosForm;
        $desMensaje  = null;        
    
        if ($alumnosForm->load(Yii::$app->request->post())) {

            if ($alumnosForm->validate()) {

                $alumno = Alumnos::findOne($alumnosForm->id_alumno);

                if ($alumno) {
                    $alumno->nombre        = $alumnosForm->nombre;
                    $alumno->apellidos     = $alumnosForm->apellidos;
                    $alumno->clase         = $alumnosForm->clase;
                    $alumno->num_documento = $alumnosForm->num_documento;

                    if ($alumno->update()) {
                        $desMensaje = "Alumno actualizado correctamente";
                        
                    } else {
                        $desMensaje = "Alumno no se actualizo";
                    }
                }
            }
        }
        
        if (!Yii::$app->request->get("id_alumno")) {
            return $this->redirect(["alumno/view"]);
        }

        $idAlumno   = Html::encode($_GET["id_alumno"]);
        $alumnoEdit = Alumnos::findOne($idAlumno);
        
        if ((!(int) $idAlumno) 
            || (!$alumnoEdit)
        ) {
            return $this->redirect(["alumno/view"]);
        }

        $alumnosForm->id_alumno     = $alumnoEdit->id_alumno;
        $alumnosForm->nombre        = $alumnoEdit->nombre;
        $alumnosForm->apellidos     = $alumnoEdit->apellidos;
        $alumnosForm->clase         = $alumnoEdit->clase;
        $alumnosForm->num_documento = $alumnoEdit->num_documento;      

        return $this->render("update", [
            "alumnosForm" => $alumnosForm, 
            "desMensaje"  => $desMensaje
        ]);
    }    

    public function actionDelete() {
        if (!Yii::$app->request->post()) {
            return $this->redirect(["alumno/view"]);
        }

        $id_alumno = Html::encode($_POST["id_alumno"]);

        if ((int) $id_alumno) {

            if (Alumnos::deleteAll("id_alumno = :id_alumno", [":id_alumno" => $id_alumno])) {
                $desMensaje = "Alumno con id: $id_alumno eliminado correctamente";
                return $this->redirect(["alumno/view"]);    
            } else {
                $desMensaje = "Error al eliminar Alumno, intente de nuevo";
                return $this->redirect(["alumno/view"]);
            }
        }            
    }
}

?>