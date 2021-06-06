<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <?php if (!empty($desMensaje)) : ?>
                <div class="form-group">
                    <div class="alert alert-success">
                        <h5><?= $desMensaje ?></h5>
                    </div>
                </div>
            <?php endif; ?>
            <h1>Editar alumno con id: <?= Html::encode($_GET["id_alumno"]) ?></h1>
        </div>   
    </div>
</div>

<div class="container">
    <div class="row">    
        <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12">
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
            </div>
        <div class="col-sm-4"></div>
    </div>
</div>