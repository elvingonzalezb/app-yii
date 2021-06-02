<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
        <div class="col-lg-9 col-xs-9">       
            <h1>Crear Alumno</h1>          
        </div> 
    </div>
</div>

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
            <?= $form->field($alumnosForm, "clase")
                    ->input("text") ?>   
        </div>

        <div class="form-group">
            <?= $form->field($alumnosForm, "num_documento")
                    ->input("text") 
                    ?>   
        </div>

        <?= Html::submitButton("Crear", [
                "class" => "btn btn-primary btn-block"
            ]) 
            ?>        

        <?php $form->end() ?>
        
    </div>
</div>