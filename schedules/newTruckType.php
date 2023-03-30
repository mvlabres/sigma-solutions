<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../controller/truckTypeController.php');
require_once('../utils.php');

$truckTypeController = new TruckTypeController($MySQLi);

if(isset($_POST['description']) && $_POST['description'] != null){
    
    $result = $truckTypeController->save($_POST);

    switch ($result) {
        case 'ALREADY_EXISTS':
            errorAlert('Já existe um tipo de veículo cadastrao com esse nome.');
            break;
        
        case 'SAVE_ERROR':
            errorAlert('Erro ao salvar. Tente novamente mais tarde ou entre em contato com o administrador.');
            break;
        
        case 'SAVED':
            successAlert('Tipo de veículo salvo com sucesso!');
            break;
    }

    $_POST = null;
}

if(isset($_GET['delete'])){

    $idDelete = $_GET['delete'];

    $result = $truckTypeController->deleteById($idDelete);

    switch ($result) {
        case 'DELETED':
            errorAlert('Registro excluído com sucesso.');
            break;
        
        case 'DELETE_ERROR':
            errorAlert('Erro ao excluir. Tente novamente mais tarde ou entre em contato com o administrador.');
            break;
    }

    $_POST = null;
}

$truckTypes = $truckTypeController->findAll();

?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Tipo de Veículo</h1>
    </div>                
</div>
<div class="row">
    <div class="col-lg-12">
         <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form-new-user" method="post" action="#" name="valida">
                        <input type="hidden" name="id" value="">
                            <div class="form-group">
                                <label>Descrição</label>
                                <input class="form-control" maxlength="100" name="description" required>
                                <p class="help-block">Insira o nome completo da nova transportadora.</p>
                            </div>
                        
                            <button id="btn-salvar" type="submit" class="btn btn-primary">Salvar</button>
                            <button type="reset" class="btn btn-danger">Cancelar</button>
                        </form>
                    </div>
                </div>    
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Visualize aqui todos os tipos de veículos.
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Descrição</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                            <?php
                                foreach($truckTypes as $truckType) { 
                                    echo '<tr class="odd gradeX">';
                                    echo '<td>'.$truckType->getId().'</td>';
                                    echo '<td>'.$truckType->getDescription().'</td>';
                                    echo '<td class="text-center"><a href="index.php?customer=tetrapak&conteudo=newTruckType.php&edit='.$truckType->getId().'"><span class="fa fa-edit text-primary"></span></a></td>';
                                    echo '<td class="text-center"><a href="index.php?customer=tetrapak&conteudo=newTruckType.php&delete='.$truckType->getId().'"><span class="fa fa-trash-o text-danger"></span></a></td>';
                                    echo '</tr>';

                                }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>