<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../controller/scheduleController.php');

date_default_timezone_set("America/Sao_Paulo");

$statusList = ['Todos','Agendado','Aguardando', 'Em operação', 'Fim de operação', 'Liberado'];

$status = 'Todos';
$startDate = date("d/m/Y") . ' 00:00:00';
$endDate = date("d/m/Y") . ' 23:59:59';

$scheduleController = new ScheduleController($MySQLi);



if(isset($_POST['status']) && $_POST['status'] != null){

    $status = $_POST['status'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
}

$schedules = $scheduleController->findByClientStatusStartDateAndEndDate($_SESSION['customerName'], $status, $startDate, $endDate);

?>

<body>

    <div class="row">
        <div class="col-lg-12">
            
            <h3>Filtro</h3>
            <div class="functions-group">
                <form method="post" action="#">
                    <div class="row-element-group">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" aria-label="Default select example">
                                <?php
        
                                foreach ($statusList as $statusValue) {
                                    
                                    $selected = '';
        
                                    if($statusValue == $status) $selected = 'selected';
                                    echo '<option value="'.$statusValue.'" '.$selected.'>'.$statusValue.'</option>';
                                }
                                ?>
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Data inicial</label>
                            <div class='input-group date' id='datetimepicker1'>
                                <input name="startDate" type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$startDate ?>"/>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Data final</label>
                            <div class='input-group date' id='datetimepicker1'>
                                <input name="endDate" type='text' data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control" value="<?=$endDate ?>"/>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </form>
                <div class="btn-functions-group">
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#columnOrder"><i class="glyphicon glyphicon-sort-by-attributes"></i> Ordenar Colunas</button>
                    <button type="button" class="btn btn-secondary"><i class="fa fa-file-excel-o"></i> Exportar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th scope="column" class="td-70">Detalhes</th>
                                    <th scope="column" class="td-70">Editar</th>
                                    <th class="td-100">Status</th>
                                    <th class="td-120">Agendamento</th>
                                    <th class="td-100">Placa Cavalo</th>
                                    <th class="td-100">Shipment ID</th>
                                    <th class="td-100">Operação</th>
                                    <th class="td-120">Transportadora</th>
                                    <th class="td-120">Chegada</th>
                                    <th class="td-70">Doca</th>
                                    <th class="td-120">Início</th>
                                    <th class="td-120">Fim</th>
                                    <th class="td-120">Saída</th>
                                    <th class="td-100">Cidade</th>
                                    <th class="td-100">Peso Final</th>
                                    <th class="td-70">NF</th>
                                    <th class="td-70">Paletes</th>
                                    <th class="td-100">Tipo Veículo</th>
                                    <th class="td-150">Observação</th>
                                    <th class="td-150">Material</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
    
                                    foreach ($schedules as $schedule) {
                                        echo '<tr>';
                                        echo '<td class="text-center"><a href="index.php?customer=tetrapak&conteudo=newSchedule.php&search='.$schedule->getId().'"><span class="fa fa-search text-primary"></span></a></td>';
                                        echo '<td class="text-center"><a href="index.php?customer=tetrapak&conteudo=newSchedule.php&edit='.$schedule->getId().'"><span class="fa fa-edit text-primary"></span></a></td>';
                                        echo '<td>'.$schedule->getStatus().'</td>';
                                        echo '<td>'.$schedule->getDataAgendamento().'</td>';
                                        echo '<td>'.$schedule->getPlacaCavalo().'</td>';
                                        echo '<td>'.$schedule->getShipmentId().'</td>';
                                        echo '<td>'.$schedule->getOperacao().'</td>';
                                        echo '<td>'.$schedule->getTransportadora().'</td>';
                                        echo '<td>'.$schedule->getHoraChegada().'</td>';
                                        echo '<td>'.$schedule->getDoca().'</td>';
                                        echo '<td>'.$schedule->getInicioOperacao().'</td>';
                                        echo '<td>'.$schedule->getFimOperacao().'</td>';
                                        echo '<td>'.$schedule->getSaida().'</td>';
                                        echo '<td>'.$schedule->getCidade().'</td>';
                                        echo '<td>'.$schedule->getPeso().'</td>';
                                        echo '<td>'.$schedule->getNf().'</td>';
                                        echo '<td>'.$schedule->getCargaQtde().'</td>';
                                        echo '<td>'.$schedule->getTipoVeiculo().'</td>';
                                        echo '<td>'.$schedule->getObservacao().'</td>';
                                        echo '<td>'.$schedule->getDadosGerais().'</td>';
                                        echo '</tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<div class="modal fade" id="columnOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered large-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ordenar colunas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

