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
    'licenceTruck'          => [],
    'dos'                   => ['porter'],
    'invoice'               => ['porter'],
    'grossWeight'           => ['porter'],
    'pallets'               => ['porter'],
    'material'              => ['porter'],
    'observation'           => ['porter'],
    'files'                 => ['porter'],
    'documentDriver'        => [],
    'driverName'            => [],
    'licenceTrailer2'       => [],
    'licenceTrailer'        => []
];

$teste = false;

$fieldAcces = [
    'operationScheduleTime' => (in_array($_SESSION['tipo'], $userTypeFieldAccess['operationScheduleTime'] )) ? 'readonly' : '',
    'arrival'               => (in_array($_SESSION['tipo'], $userTypeFieldAccess['arrival'] )) ? 'readonly' : '',
    'operationStart'        => (in_array($_SESSION['tipo'], $userTypeFieldAccess['operationStart'] )) ? 'readonly' : '',
    'operationDone'         => (in_array($_SESSION['tipo'], $userTypeFieldAccess['operationDone'] )) ? 'readonly' : '',
    'operationExit'         => (in_array($_SESSION['tipo'], $userTypeFieldAccess['operationExit'] )) ? 'readonly' : '',
    'operationType'         => (in_array($_SESSION['tipo'], $userTypeFieldAccess['operationType'] )) ? 'disabled' : '',
    'shippingCompany'       => (in_array($_SESSION['tipo'], $userTypeFieldAccess['shippingCompany'] )) ? 'disabled' : '',
    'city'                  => (in_array($_SESSION['tipo'], $userTypeFieldAccess['city'] )) ? 'readonly' : '',
    'binSeparation'         => (in_array($_SESSION['tipo'], $userTypeFieldAccess['binSeparation'] )) ? 'readonly' : '',
    'shipmentId'            => (in_array($_SESSION['tipo'], $userTypeFieldAccess['shipmentId'] )) ? 'readonly' : '',
    'dock'                  => (in_array($_SESSION['tipo'], $userTypeFieldAccess['dock'] )) ? 'readonly' : '',
    'truckType'             => (in_array($_SESSION['tipo'], $userTypeFieldAccess['truckType'] )) ? 'disabled' : '',
    'licenceTruck'          => (in_array($_SESSION['tipo'], $userTypeFieldAccess['licenceTruck'] )) ? 'readonly' : '',
    'dos'                   => (in_array($_SESSION['tipo'], $userTypeFieldAccess['dos'] )) ? 'readonly' : '',
    'invoice'               => (in_array($_SESSION['tipo'], $userTypeFieldAccess['invoice'] )) ? 'readonly' : '',
    'grossWeight'           => (in_array($_SESSION['tipo'], $userTypeFieldAccess['grossWeight'] )) ? 'readonly' : '',
    'pallets'               => (in_array($_SESSION['tipo'], $userTypeFieldAccess['pallets'] )) ? 'readonly' : '',
    'material'              => (in_array($_SESSION['tipo'], $userTypeFieldAccess['material'] )) ? 'readonly' : '',
    'observation'           => (in_array($_SESSION['tipo'], $userTypeFieldAccess['observation'] )) ? 'readonly' : '',
    'files'                 => (in_array($_SESSION['tipo'], $userTypeFieldAccess['files'] )) ? 'disabled' : '',
    'documentDriver'        => (in_array($_SESSION['tipo'], $userTypeFieldAccess['documentDriver'] )) ? 'readonly' : '',
    'driverName'            => (in_array($_SESSION['tipo'], $userTypeFieldAccess['driverName'] )) ? 'readonly' : '',
    'licenceTrailer2'       => (in_array($_SESSION['tipo'], $userTypeFieldAccess['licenceTrailer2'] )) ? 'readonly' : '',
    'licenceTrailer'        => (in_array($_SESSION['tipo'], $userTypeFieldAccess['licenceTrailer'] )) ? 'readonly' : ''
];

$schedule = new Schedule();

$action = 'save'; 

$readonly = '';
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
            echo "<script>window.location='index.php?conteudo=searchSchedule.php&action=schedule-save'</script>";	
            break;
        
        
        case 'UPDATED':
            echo "<script>window.location='index.php?conteudo=searchSchedule.php&action=schedule-update'</script>";	
            break;
        
        
        case 'SAVE_ERROR':
            errorAlert('Ocorreu um erro ao salvar o agendamento. Tente novamente ou entre em contato com o administrador.');
            break;
    }
}

if(isset($_GET['search']) && $_GET['search'] != null){

    $searchId = $_GET['search'];
    $schedule = $scheduleController->findById($searchId);
    $readonly = 'readonly';
    $disabled = 'disabled';
}

if(isset($_GET['edit']) && $_GET['edit'] != null){

    $action = 'edit';
    $editId = $_GET['edit'];
    $schedule = $scheduleController->findById($editId);
    $readonly = '';
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
                <form role="form-new-user" onsubmit="return validateStatus()" method="post" action="#" name="valida" enctype="multipart/form-data">
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
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getDataAgendamento() ?>" name="operationScheduleTime" id="operationScheduleTime" <?=$readonly ?> onblur="dateTimeHandleBlur(this)" <?=$fieldAcces['operationScheduleTime'] ?> minlength="19" maxlength="19"  required/>
                                    
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Chegada</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getHoraChegada() ?>" name="arrival" id="arrival" <?=$readonly ?> onblur="dateTimeHandleBlur(this)" <?=$fieldAcces['arrival'] ?> minlength="19" maxlength="19" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Início</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getInicioOperacao() ?>" name="operationStart" id="operationStart" <?=$readonly ?> onblur="dateTimeHandleBlur(this)" <?=$fieldAcces['operationStart'] ?> minlength="19" maxlength="19" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Fim</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getFimOperacao() ?>" name="operationDone" id="operationDone" <?=$disabled ?> onblur="dateTimeHandleBlur(this)" <?=$fieldAcces['operationDone'] ?> minlength="19" maxlength="19" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Saída</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$schedule->getSaida() ?>" name="operationExit" id="operationExit" <?=$readonly ?> onblur="dateTimeHandleBlur(this)" <?=$fieldAcces['operationExit'] ?> minlength="19" maxlength="19" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nome Motorista</label>
                                <input class="form-control" type="text" value="<?=$schedule->getNomeMotorista() ?>" name="driverName" id="driverName"  <?=$readonly ?> <?=$fieldAcces['driverName'] ?>>
                            </div>
                            <div class="form-group">
                                <label>CPF Motorista</label>
                                <input class="form-control cpf" id="cpf" type="text" value="<?=$schedule->getDocumentoMotorista() ?>" name="documentDriver"  <?=$readonly ?> <?=$fieldAcces['documentDriver'] ?>>
                            </div>
                            <div class="form-group">
                                <label>Tipo de Operação</label>
                                <select name="operationType" id="operationType" class="form-control" aria-label="Default select example" <?=$disabled ?> <?=$fieldAcces['operationType'] ?> required>
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
                                <select name="shippingCompany" class="form-control" aria-label="Default select example" id="shippingCompany"  <?=$disabled ?> <?=$fieldAcces['shippingCompany'] ?> required>
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
                                <input class="form-control" type="text" value="<?=$schedule->getCidade() ?>" name="city" id="city" <?=$readonly ?> <?=$fieldAcces['city'] ?> required>
                            </div>
                            <div class="form-group">
                                <label>Separação/Bin</label>
                                <input class="form-control" type="text" value="<?=$schedule->getSeparacao() ?>" name="binSeparation" id="binSeparation" <?=$readonly ?> <?=$fieldAcces['binSeparation'] ?> >
                            </div>
                        
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Shipment ID </label>
                                <input class="form-control" type="text" value="<?=$schedule->getShipmentId() ?>" name="shipmentId" id="shipmentId" <?=$readonly ?> <?=$fieldAcces['shipmentId'] ?> required>
                            </div>
                            <div class="form-group">
                                <label>Doca </label>
                                <input class="form-control" type="text" value="<?=$schedule->getDoca() ?>" name="dock" id="dock" <?=$readonly ?> <?=$fieldAcces['dock'] ?> >
                            </div>
                            <div class="form-group">
                                <label>Tipo de Veículo</label>
                                <select name="truckType" class="form-control placeholder" aria-label="Default select example" id="truckType" <?=$disabled ?> <?=$fieldAcces['truckType'] ?> required>
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
                                <input class="form-control" type="text"  value="<?=$schedule->getPlacaCavalo() ?>" name="licenceTruck" id="licenceTruck" <?=$readonly ?> <?=$fieldAcces['licenceTruck'] ?> >
                            </div>
                            <div class="form-group">
                                <label>Placa Carreta 1</label>
                                <input class="form-control" type="text"  value="<?=$schedule->getPlacaCarreta() ?>" name="licenceTrailer" id="licenceTrailer"  <?=$readonly ?> <?=$fieldAcces['licenceTrailer'] ?> >
                            </div>
                            <div class="form-group">
                                <label>Placa Carreta 2</label>
                                <input class="form-control" type="text"  value="<?=$schedule->getPlacaCarreta2() ?>" name="licenceTrailer2" id="licenceTrailer2" <?=$readonly ?> <?=$fieldAcces['licenceTrailer2'] ?> >
                            </div>
                            <div class="form-group">
                                <label>DO's</label>
                                <input class="form-control" id="dos" value="Não" type="text" value="<?=$schedule->getDo_s() ?>" name="dos" <?=$readonly ?> <?=$fieldAcces['dos'] ?> required>
                            </div>
                            <div class="form-group">
                                <label>Nota Fiscal</label>
                                <input class="form-control" type="text" value="<?=$schedule->getNf() ?>" name="invoice" id="invoice" <?=$readonly ?> <?=$fieldAcces['invoice'] ?> >
                            </div>
                            <div class="form-group">
                                <label>Peso Bruto</label>
                                <input class="form-control" type="text" value="<?=$schedule->getPeso() ?>" name="grossWeight" id="grossWeight" <?=$readonly ?> <?=$fieldAcces['grossWeight'] ?> >
                            </div>
                            <div class="form-group">
                                <label>Paletes</label>
                                <input class="form-control" type="number" value="<?=$schedule->getCargaQtde() ?>" name="pallets" id="pallets" <?=$readonly ?> <?=$fieldAcces['pallets'] ?> >
                            </div>
                            <div class="form-group">
                                <label>Material</label>
                                <textarea class="form-control" type="text"  name="material" <?=$readonly ?> <?=$fieldAcces['material'] ?> id="material" required><?=$schedule->getDadosGerais() ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Observação</label>
                                <textarea class="form-control" type="text"  name="observation" <?=$readonly ?> <?=$fieldAcces['observation'] ?> id="observation" required><?=$schedule->getObservacao() ?></textarea>
                            </div>
                        </div> 
                    </div>
                    <div class="full-container">
                        <p class="mt-5 text-left">
                            <label for="attachment">
                                <a class="btn btn-primary text-light" role="button" aria-disabled="false" <?=$fieldAcces['files'] ?> <?=$fileFieldDisabled ?>>+ Anexos</a>
                                
                            </label>
                            <input type="file" name="file[]"  id="attachment" style="visibility: hidden; position: absolute;" multiple onchange="handleChangeFiles()" <?=$fieldAcces['files'] ?> <?=$fileFieldDisabled ?>/>
                            
                        </p>
                        <p id="files-area">
                            <span id="filesList">
                                <span id="files-names">
                                    <?php

                                    if((isset($_GET['search']) && $_GET['search'] != null) || (isset($_GET['edit']) && $_GET['edit'] != null)){

                                        foreach ($schedule->getFilesPath() as $path) {

                                            $fileName = substr($path, strrpos($path, '/') + 1);

                                            echo '<span class="file-block">';
                                            echo    '<a class="file-saved" href="'.$path.'" download>';
                                            echo        '<span class="name">'.$fileName.'</span>';
                                            echo    '</a>';
                                            echo '</span>';
                                        }
                                    }
                                    ?>
                                </span>
                            </span>
                        </p>
                    </div> 
                    <div class="btn-group-end">
                        <button id="btn-salvar" type="submit" class="btn btn-primary" <?=$disabled ?>>Salvar</button>
                        <a href="index.php?conteudo=searchSchedule.php" type="reset" class="btn btn-danger">Cancelar</a> 
                    </div> 
                </form>
            </div>
        </div>
    </div>
</div>

