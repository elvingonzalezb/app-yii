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
        <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center">       
                            <h1>Crear Usuario</h1>          
                        </div> 
                        <?php $form = ActiveForm::begin([
                            "method"                 => "post",
                            'id'                     => 'formulario',
                            'enableClientValidation' => false,
                            'enableAjaxValidation'   => true,
                        ]);
                        ?>

                        <div class="form-group">
                            <?= $form->field($userModel, "username")->input("text") ?>   
                        </div>

                        <div class="form-group">
                            <?= $form->field($userModel, "email")->input("text") ?>   
                        </div>

                        <div class="form-group">
                            <?= $form->field($userModel, "password")
                                    ->input("password") ?>   
                        </div>

                        <div class="form-group">
                            <?= $form->field($userModel, "password_repeat")
                                    ->input("password") ?>    
                        </div>

                        <?= Html::submitButton("Registrar", [
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