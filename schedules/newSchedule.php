<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../controller/shippingCompanyController.php');
require_once('../controller/truckTypeController.php');
require_once('../controller/scheduleController.php');
require_once('../controller/operationTypeController.php');
require_once('../model/schedule.php');
require_once('../utils.php');

$schedule = new Schedule();
$action = 'save'; 

$disabled = '';

$shippingCompanyController = new ShippingCompanyController($MySQLi);
$truckTypeController = new TruckTypeController($MySQLi);
$scheduleController = new ScheduleController($MySQLi);
$operationTypeController = new OperationTypeController($MySQLi);

if(isset($_POST['action'])){

    $result;

    if($_POST['action'] == 'save'){

        $result = $scheduleController->save($_POST);
    } else if($_POST['action'] == 'edit'){
        $result = $scheduleController->update($_POST);
    }
    
    switch ($result) {
        case 'SAVED':
            successAlert('Agendamento realizado com sucesso!');
            break;
        
        case 'UPDATED':
            successAlert('Agendamento atualizado com sucesso!');
            break;
        
        case 'SAVE_ERROR':
            errorAlert('Ocorreu um erro ao salvar o agendamento. Tente novamente ou entre em contato com o administrador.');
            break;
    }
}

if(isset($_GET['search']) && $_GET['search'] != null){

    $searchId = $_GET['search'];
    $schedule = $scheduleController->findById($searchId);
    $disabled = 'disabled';
}

if(isset($_GET['edit']) && $_GET['edit'] != null){

    $action = 'edit';
    $editId = $_GET['edit'];
    $schedule = $scheduleController->findById($editId);
    $disabled = '';
}


$shippingCompanys = $shippingCompanyController->findByClient($_SESSION['customerName']);
$truckTypes = $truckTypeController->findAll();
$operationTypes = $operationTypeController->findByClient($_SESSION['customerName']);

$statusFieldColor = ($schedule->getStatus() == 'Liberado') ? 'success-text-field' : 'warning-text-field';

?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Novo Agendamento</h1>
    </div>                
</div>
<div class="row">
    <div class="col-lg-12">
         <div class="panel panel-default">
            <div class="panel-body">
                <form role="form-new-user"  onsubmit="return validateStatus()" method="post" action="#" name="valida">
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="hidden" name="id" value="<?=$editId ?>">
                            <input type="hidden" name="action" value="<?=$action ?>" >
                            <div class="form-group">
                                <label>Status</label>
                                <input type='text' class="invisible-disabeld-field form-control <?=$statusFieldColor ?>" value="<?php if($schedule->getStatus()==null) echo 'Novo'; else echo $schedule->getStatus() ?>" name="scheduleStatus" id="scheduleStatus" readonly/> 
                            </div>
                            <div class="form-group">
                                <label>Horário Carregamento</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getDataAgendamento() ?>" name="operationScheduleTime" id="operationScheduleTime" <?=$disabled ?> required/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Chegada</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getHoraChegada() ?>" name="arrival" id="arrival" <?=$disabled ?> onblur="dateTimeHandleBlur(this)" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Início</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getInicioOperacao() ?>" name="operationStart" id="operationStart" <?=$disabled ?> onblur="dateTimeHandleBlur(this)"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Fim</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getFimOperacao() ?>" name="operationDone" id="operationDone" <?=$disabled ?> onblur="dateTimeHandleBlur(this)"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Saída</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getSaida() ?>" name="operationExit" id="operationExit" <?=$disabled ?> onblur="dateTimeHandleBlur(this)"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tipo de Operação</label>
                                <select name="operationType" class="form-control" aria-label="Default select example" <?=$disabled ?> required>
                                    <option value="">Selecione...</option>
                                    <?php
                                    foreach ($operationTypes as $operationType) {

                                        $selected = null;
                                        if($schedule->getOperacao() == $operationType->getName()) $selected = 'selected';

                                        echo '<option value="'.$operationType->getName().'" '.$selected.' >'.$operationType->getName().'</option>';
                                    }
                                    ?>
                                  </select>
                            </div>
                            <div class="form-group">
                                <label>Transportadora</label>
                                <select name="shippingCompany" class="form-control" aria-label="Default select example"  <?=$disabled ?> required>
                                    <option value="">Selecione...</option>
                                    <?php

                                    if(count($shippingCompanys) > 0){
                                        foreach ($shippingCompanys as $shippingCompany) {
    
                                            $selected = null;
                                            if($schedule->getTransportadora() == $shippingCompany->getNome()) $selected = 'selected';
    
                                            echo '<option value="'.$shippingCompany->getNome().'" '.$selected.' >'.$shippingCompany->getNome().'</option>';
                                        }
                                    }
                                    ?>
                                  </select>
                            </div>
                            <div class="form-group">
                                <label>Cidade</label>
                                <input class="form-control" type="text" value="<?=$schedule->getCidade() ?>" name="city"  <?=$disabled ?> required>
                            </div>
                            <div class="form-group">
                                <label>Separação/Bin</label>
                                <input class="form-control" type="text" value="<?=$schedule->getSeparacao() ?>" name="binSeparation" <?=$disabled ?>>
                            </div>
                        
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Shipment ID </label>
                                <input class="form-control" type="text" value="<?=$schedule->getShipmentId() ?>" name="shipmentId"  <?=$disabled ?> required>
                            </div>
                            <div class="form-group">
                                <label>Doca </label>
                                <input class="form-control" type="text" value="<?=$schedule->getDoca() ?>" name="dock"  <?=$disabled ?> >
                            </div>
                            <div class="form-group">
                                <label>Tipo de Veículo</label>
                                <select name="truckType" class="form-control placeholder" aria-label="Default select example"  <?=$disabled ?> >
                                    <option value="">Selecione...</option>
                                    <?php
                                    foreach ($truckTypes as $truckType) {

                                        $selected = null;
                                        if($schedule->getTipoVeiculo() == $truckType->getDescription()) $selected = 'selected';

                                        echo '<option value="'.$truckType->getDescription().'" '.$selected.' >'.$truckType->getDescription().'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Placa do cavalo</label>
                                <input class="form-control" type="text"  value="<?=$schedule->getPlacaCavalo() ?>" name="licenceTruck"  <?=$disabled ?>>
                            </div>
                            <div class="form-group">
                                <label>DO's</label>
                                <input class="form-control"  value="Não" type="text" value="<?=$schedule->getDo_s() ?>" name="dos" <?=$disabled ?> >
                            </div>
                            <div class="form-group">
                                <label>Nota Fiscal</label>
                                <input class="form-control" type="text" value="<?=$schedule->getNf() ?>" name="invoice"  <?=$disabled ?>>
                            </div>
                            <div class="form-group">
                                <label>Peso Bruto</label>
                                <input class="form-control" type="text" value="<?=$schedule->getPeso() ?>" name="grossWeight"  <?=$disabled ?>>
                            </div>
                            <div class="form-group">
                                <label>Paletes</label>
                                <input class="form-control" type="number" value="<?=$schedule->getCargaQtde() ?>" name="pallets"  <?=$disabled ?>>
                            </div>
                            <div class="form-group">
                                <label>Material</label>
                                <textarea class="form-control" type="text"  name="material" <?=$disabled ?> required><?=$schedule->getDadosGerais() ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Observação</label>
                                <textarea class="form-control" type="text"  name="observation" <?=$disabled ?>> <?=$schedule->getObservacao() ?> </textarea>
                            </div>
                        </div> 
                    </div>
                    <div class="full-container">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupFile01">Novo Anexo</label>
                            <input type="file" class="form-control" id="inputGroupFile01" <?=$disabled ?>>
                        </div>
                    </div>  
                    <button id="btn-salvar" type="submit" class="btn btn-primary" <?=$disabled ?>>Salvar</button>
                    <button type="reset" class="btn btn-danger" <?=$disabled ?>>Cancelar</button> 
                </form>
            </div>
        </div>
    </div>
</div>

