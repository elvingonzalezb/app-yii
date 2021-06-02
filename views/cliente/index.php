<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

?>

<h3>Lista de Clientes</h3>
<table class="table table-hover">
    <tr>      
        <th>Nombre</th>
        <th>Compañia</th>
        <th>Telefono</th>  
    </tr>
    <?php foreach($clientes as $cliente): ?>
    <tr>       
        <td><?= $cliente->name ?></td>
        <td><?= $cliente->company ?></td>
        <td><?= $cliente->mobile ?></td>             
    </tr>
    <?php endforeach ?>
</table>