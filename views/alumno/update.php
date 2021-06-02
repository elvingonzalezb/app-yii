<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>
<?php if (!empty($desMensaje)) : ?>
    <div class="form-group">
        <div class="alert alert-success">
            <h5><?= $desMensaje ?></h5>
        </div>
    </div>
<?php endif; ?>

<div class="container">
    <div class="row">
        <div class="col-lg-5">
            <h1>Editar alumno con id: <?= Html::encode($_GET["id_alumno"]) ?></h1>
        </div>   
    </div>
</div>

<h3><?= $desMensaje ?></h3>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin([
                        "method"                 => "post",
                        'enableClientValidation' => true,
                    ]);
                    ?>

        <?= $form->field($alumnosForm, "id_alumno")->input("hidden")->label(false) ?>

        <div class="form-group">
            <?= $form->field($alumnosForm, "nombre")->input("text") ?>   
        </div>

        <div class="form-group">
            <?= $form->field($alumnosForm, "apellidos")->input("text") ?>   
        </div>

        <div class="form-group">
            <?= $form->field($alumnosForm, "clase")
                    ->input("text")
                    ?>   
        </div>

        <div class="form-group">
            <?= $form->field($alumnosForm, "num_documento")
                    ->input("text") 
                    ?>   
        </div>

        <?= Html::submitButton("Actualizar", [
                "class" => "btn btn-primary btn-block"
            ]) 
            ?>

        <?php $form->end() ?>
        
    </div>
</div>