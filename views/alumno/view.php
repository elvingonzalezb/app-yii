<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;

?>

<div class="container">
<?php if (!empty($desMensaje)) : ?>
            <div class="form-group">
                <div class="alert alert-success">
                    <h5><?= $desMensaje ?></h5>
                </div>
            </div>
        <?php endif; ?>
    <div class="row">
        <div class="col-lg-9 col-xs-9">
                            
            <?php $aBusqueda = ActiveForm::begin([
                "method"                 => "get",
                "action"                 => Url::toRoute("alumno/view"),
                "enableClientValidation" => true,
            ]);
            ?>
            <div class="row">
                <div class="col-lg-9 col-xs-9">   
                    <div class="form-group">
                        <?= $aBusqueda->field($searchForm, "q")->input("search")->label(false) ?>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-3"> 
                    <div class="form-group">
                        <?= Html::submitButton("Buscar", [
                                "class" => "btn btn-primary"
                            ]) 
                            ?>
                    </div>
                </div>
            </div>

            <?php $aBusqueda->end() ?>
        </div>

        <div class="col-lg-3 col-xs-3">
            <div class="form-group">                                
                <a href="<?= Url::toRoute("alumno/create") ?>" class="btn btn-primary">Nuevo alumno</a>            
            </div>
        </div>  
    </div>
</div>

<h3>Lista de alumnos</h3>
<table class="table table-hover">
    <tr>
        <th>Id Alumno</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Número Clase</th>
        <th>Número de documento</th>
        <th class="text-center">Opciones</th>       
    </tr>
    <?php foreach($alumnos as $alumno): ?>
    <tr>
        <td><?= $alumno->id_alumno ?></td>
        <td><?= $alumno->nombre ?></td>
        <td><?= $alumno->apellidos ?></td>
        <td><?= $alumno->clase ?></td>
        <td><?= $alumno->num_documento ?></td>        
        <td>
        <a href="<?= Url::toRoute(["alumno/update", "id_alumno" => $alumno->id_alumno]) ?>" class="btn btn-success">Editar</a>  
        <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#id_alumno_<?= $alumno->id_alumno ?>">Eliminar</a>           
            <div class="modal fade" role="dialog" aria-hidden="true" id="id_alumno_<?= $alumno->id_alumno ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Eliminar alumno</h4>
                        </div>
                        <div class="modal-body">
                            <p>¿Realmente deseas eliminar al alumno con id <?= $alumno->id_alumno ?>?</p>
                        </div>
                        <div class="modal-footer">
                        <?= Html::beginForm(Url::toRoute("alumno/delete"), "POST") ?>
                            <input type="hidden" name="id_alumno" value="<?= $alumno->id_alumno ?>">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-warning"><i class="fas fa-user"></i> Eliminar</button>
                        <?= Html::endForm() ?>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <?php endforeach ?>
</table>
<?= LinkPager::widget([
    "pagination" => $pages,
]);