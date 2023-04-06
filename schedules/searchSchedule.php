<?php
require_once('../controller/scheduleController.php');

$scheduleController = new ScheduleController($MySQLi);

$schedules = $scheduleController->findByClient($_SESSION['customerName']);

?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Agendamentos</h3>
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
