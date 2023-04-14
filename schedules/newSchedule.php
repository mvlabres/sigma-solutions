<?php

require_once('../controller/shippingCompanyController.php');
require_once('../controller/truckTypeController.php');
require_once('../controller/scheduleController.php');
require_once('../controller/operationTypeController.php');
require_once('../model/schedule.php');
require_once('../utils.php');

if($_SESSION['FUNCTION_ACCESS']['schedule_new'] == 'hidden' && (!isset($_GET['edit']) || $_GET['edit'] == null)) {
    echo "<script>window.location='/sigma-solutions/schedules/index.php'</script>";
}

$userTypeFieldAccess = [
    'operationScheduleTime' => ['operator', 'porter'],
    'arrival'               => ['client', 'operator'],
    'operationStart'        => ['client', 'porter'],
    'operationDone'         => ['client', 'porter'],
    'operationExit'         => ['client', 'operator'],
    'operationType'         => ['porter'],
    'shippingCompany'       => ['porter'],
    'city'                  => ['porter'],
    'binSeparation'         => ['porter'],
    'shipmentId'            => ['operator', 'porter'],
    'dock'                  => ['porter'],
    'truckType'             => ['porter'],
    'licenceTruck'          => ['porter'],
    'dos'                   => ['porter'],
    'invoice'               => ['porter'],
    'grossWeight'           => ['porter'],
    'pallets'               => ['porter'],
    'material'              => ['porter'],
    'observation'           => ['porter'],
    'files'                 => ['porter']
];

$teste = false;

$fieldAcces = [
    'operationScheduleTime' => (in_array($_SESSION['tipo'], $userTypeFieldAccess['operationScheduleTime'] )) ? 'disabled' : '',
    'arrival'               => (in_array($_SESSION['tipo'], $userTypeFieldAccess['arrival'] )) ? 'disabled' : '',
    'operationStart'        => (in_array($_SESSION['tipo'], $userTypeFieldAccess['operationStart'] )) ? 'disabled' : '',
    'operationDone'         => (in_array($_SESSION['tipo'], $userTypeFieldAccess['operationDone'] )) ? 'disabled' : '',
    'operationExit'         => (in_array($_SESSION['tipo'], $userTypeFieldAccess['operationExit'] )) ? 'disabled' : '',
    'operationType'         => (in_array($_SESSION['tipo'], $userTypeFieldAccess['operationType'] )) ? 'disabled' : '',
    'shippingCompany'       => (in_array($_SESSION['tipo'], $userTypeFieldAccess['shippingCompany'] )) ? 'disabled' : '',
    'city'                  => (in_array($_SESSION['tipo'], $userTypeFieldAccess['city'] )) ? 'disabled' : '',
    'binSeparation'         => (in_array($_SESSION['tipo'], $userTypeFieldAccess['binSeparation'] )) ? 'disabled' : '',
    'shipmentId'            => (in_array($_SESSION['tipo'], $userTypeFieldAccess['shipmentId'] )) ? 'disabled' : '',
    'dock'                  => (in_array($_SESSION['tipo'], $userTypeFieldAccess['dock'] )) ? 'disabled' : '',
    'truckType'             => (in_array($_SESSION['tipo'], $userTypeFieldAccess['truckType'] )) ? 'disabled' : '',
    'licenceTruck'          => (in_array($_SESSION['tipo'], $userTypeFieldAccess['licenceTruck'] )) ? 'disabled' : '',
    'dos'                   => (in_array($_SESSION['tipo'], $userTypeFieldAccess['dos'] )) ? 'disabled' : '',
    'invoice'               => (in_array($_SESSION['tipo'], $userTypeFieldAccess['invoice'] )) ? 'disabled' : '',
    'grossWeight'           => (in_array($_SESSION['tipo'], $userTypeFieldAccess['grossWeight'] )) ? 'disabled' : '',
    'pallets'               => (in_array($_SESSION['tipo'], $userTypeFieldAccess['pallets'] )) ? 'disabled' : '',
    'material'              => (in_array($_SESSION['tipo'], $userTypeFieldAccess['material'] )) ? 'disabled' : '',
    'observation'           => (in_array($_SESSION['tipo'], $userTypeFieldAccess['observation'] )) ? 'disabled' : '',
    'files'                 => (in_array($_SESSION['tipo'], $userTypeFieldAccess['files'] )) ? 'disabled' : ''
];

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
                <form role="form-new-user" onsubmit="return validateStatus()" method="post" action="#" name="valida">
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
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getDataAgendamento() ?>" name="operationScheduleTime" id="operationScheduleTime" <?=$disabled ?> onblur="dateTimeHandleBlur(this)" <?=$fieldAcces['operationScheduleTime'] ?> required/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Chegada</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getHoraChegada() ?>" name="arrival" id="arrival" <?=$disabled ?> onblur="dateTimeHandleBlur(this)" <?=$fieldAcces['arrival'] ?>/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Início</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getInicioOperacao() ?>" name="operationStart" id="operationStart" <?=$disabled ?> onblur="dateTimeHandleBlur(this)" <?=$fieldAcces['operationStart'] ?>/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Fim</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getFimOperacao() ?>" name="operationDone" id="operationDone" <?=$disabled ?> onblur="dateTimeHandleBlur(this)" <?=$fieldAcces['operationDone'] ?> />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Saída</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getSaida() ?>" name="operationExit" id="operationExit" <?=$disabled ?> onblur="dateTimeHandleBlur(this)" <?=$fieldAcces['operationExit'] ?> />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tipo de Operação</label>
                                <select name="operationType" class="form-control" aria-label="Default select example" <?=$disabled ?> <?=$fieldAcces['operationType'] ?> required>
                                    <option value="">Selecione...</option>
                                    <?php

                                    if(count($operationTypes) > 0){
                                        foreach ($operationTypes as $operationType) {
    
                                            $selected = null;
                                            if($schedule->getOperacao() == $operationType->getName()) $selected = 'selected';
    
                                            echo '<option value="'.$operationType->getName().'" '.$selected.' >'.$operationType->getName().'</option>';
                                        }
                                    }
                                    ?>
                                  </select>
                            </div>
                            <div class="form-group">
                                <label>Transportadora</label>
                                <select name="shippingCompany" class="form-control" aria-label="Default select example"  <?=$disabled ?> <?=$fieldAcces['shippingCompany'] ?> required>
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
                                <input class="form-control" type="text" value="<?=$schedule->getCidade() ?>" name="city"  <?=$disabled ?> <?=$fieldAcces['city'] ?> required>
                            </div>
                            <div class="form-group">
                                <label>Separação/Bin</label>
                                <input class="form-control" type="text" value="<?=$schedule->getSeparacao() ?>" name="binSeparation" <?=$disabled ?> <?=$fieldAcces['binSeparation'] ?> >
                            </div>
                        
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Shipment ID </label>
                                <input class="form-control" type="text" value="<?=$schedule->getShipmentId() ?>" name="shipmentId"  <?=$disabled ?> <?=$fieldAcces['shipmentId'] ?> required>
                            </div>
                            <div class="form-group">
                                <label>Doca </label>
                                <input class="form-control" type="text" value="<?=$schedule->getDoca() ?>" name="dock"  <?=$disabled ?> <?=$fieldAcces['dock'] ?> >
                            </div>
                            <div class="form-group">
                                <label>Tipo de Veículo</label>
                                <select name="truckType" class="form-control placeholder" aria-label="Default select example"  <?=$disabled ?> <?=$fieldAcces['truckType'] ?>>
                                    <option value="">Selecione...</option>
                                    <?php

                                    if(count($truckTypes) > 0){
                                        foreach ($truckTypes as $truckType) {
    
                                            $selected = null;
                                            if($schedule->getTipoVeiculo() == $truckType->getDescription()) $selected = 'selected';
    
                                            echo '<option value="'.$truckType->getDescription().'" '.$selected.' >'.$truckType->getDescription().'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Placa do cavalo</label>
                                <input class="form-control" type="text"  value="<?=$schedule->getPlacaCavalo() ?>" name="licenceTruck"  <?=$disabled ?> <?=$fieldAcces['licenceTruck'] ?> >
                            </div>
                            <div class="form-group">
                                <label>DO's</label>
                                <input class="form-control"  value="Não" type="text" value="<?=$schedule->getDo_s() ?>" name="dos" <?=$disabled ?> <?=$fieldAcces['dos'] ?> >
                            </div>
                            <div class="form-group">
                                <label>Nota Fiscal</label>
                                <input class="form-control" type="text" value="<?=$schedule->getNf() ?>" name="invoice"  <?=$disabled ?> <?=$fieldAcces['invoice'] ?> >
                            </div>
                            <div class="form-group">
                                <label>Peso Bruto</label>
                                <input class="form-control" type="text" value="<?=$schedule->getPeso() ?>" name="grossWeight"  <?=$disabled ?> <?=$fieldAcces['grossWeight'] ?> >
                            </div>
                            <div class="form-group">
                                <label>Paletes</label>
                                <input class="form-control" type="number" value="<?=$schedule->getCargaQtde() ?>" name="pallets"  <?=$disabled ?> <?=$fieldAcces['pallets'] ?> >
                            </div>
                            <div class="form-group">
                                <label>Material</label>
                                <textarea class="form-control" type="text"  name="material" <?=$disabled ?> <?=$fieldAcces['material'] ?> required><?=$schedule->getDadosGerais() ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Observação</label>
                                <textarea class="form-control" type="text"  name="observation" <?=$disabled ?> <?=$fieldAcces['observation'] ?> > <?=$schedule->getObservacao() ?> </textarea>
                            </div>
                        </div> 
                    </div>
                    <div class="full-container">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupFile01">Novo Anexo</label>
                            <input type="file" class="form-control" id="inputGroupFile01" name="files" <?=$disabled ?> <?=$fieldAcces['files'] ?> >
                        </div>
                    </div>  
                    <button id="btn-salvar" type="submit" class="btn btn-primary" <?=$disabled ?>>Salvar</button>
                    <button type="reset" class="btn btn-danger" <?=$disabled ?>>Cancelar</button> 
                </form>
            </div>
        </div>
    </div>
</div>

