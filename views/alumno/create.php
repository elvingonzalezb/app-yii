<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<h1>Crear Alumno</h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                "method"                 => "post",
                'enableClientValidation' => true,
            ]);
            ?>

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

            <?= Html::submitButton("Crear", [
                    "class" => "btn btn-primary"
                ]) 
                ?>

            <?php if (!empty($desMensaje)) : ?>
                <div class="form-group">
                    <div class="alert alert-success">
                        <h5><?= $desMensaje ?></h5>
                    </div>
                </div>
            <?php endif; ?>

            <?php $form->end() ?>
        </div>
    </div>