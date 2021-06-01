<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="container">
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">                   
                    <a href="<?= Url::toRoute("alumno/view") ?>" class="btn btn-primary float-right">Atras</a>
                </div>
            </div>
        </div>   
    </div>
</div>

<h1>Editar alumno con id <?= Html::encode($_GET["id_alumno"]) ?></h1>

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
            <?= $form->field($alumnosForm, "clase")->input("text") ?>   
        </div>

        <div class="form-group">
            <?= $form->field($alumnosForm, "nota_final")->input("text") ?>   
        </div>

        <?= Html::submitButton("Actualizar", [
                "class" => "btn btn-primary"
            ]) 
            ?>

        <?php $form->end() ?>
    </div>
</div>