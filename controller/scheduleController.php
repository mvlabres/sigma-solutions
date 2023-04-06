<?php

require_once('../repository/scheduleRepository.php');
require_once('../model/schedule.php');

class ScheduleController{

    private $schedule;
    private $scheduleRepository;
    private $mySql;

    public function __construct($mySql){

        $this->mySql = $mySql;
        $this->scheduleRepository = new ScheduleRepository($this->mySql);
    }

    public function save($post){

        try {

            $schedule = new Schedule();
            $schedule->setStatus('Novo'); 

            $schedule = $this->setFields($post, $schedule);
            return $this->scheduleRepository->save($schedule);
        
        } catch (Exception $e) {
            return 'SAVE_ERROR';
        }
    }

    public function findByClient($client){

        $result = $this->scheduleRepository->findByClient($client);
        $data = $this->loadData($result);

        return $data;
    }

    public function findById($id){

        $result = $this->scheduleRepository->findById($id);
        $data = $this->loadData($result);

        if(count($data) > 0) return $data[0];

        return $data;
    }

    public function setFields($post, $schedule){

        $schedule->setTransportadora($post['shippingCompany']);
        $schedule->setTipoVeiculo($post['truckType']);
        $schedule->setPlacaCavalo($post['licenceTruck']);
        $schedule->setOperacao($post['operationType']);
        $schedule->setNf($post['invoice']);
        $schedule->setHoraChegada(date("Y-m-d H:m:s", strtotime(str_replace('/', '-', $post['arrival'] ))));
        $schedule->setInicioOperacao(date("Y-m-d H:m:s", strtotime(str_replace('/', '-', $post['operationStart'] ))));
        $schedule->setFimOperacao(date("Y-m-d H:m:s", strtotime(str_replace('/', '-', $post['operationDone'] ))));
        $schedule->setNomeUsuario($_SESSION['nome']);
        $schedule->setDataInclusao(date("Y-m-d H:m:s"));
        $schedule->setPeso($post['grossWeight']);
        $schedule->setDataAgendamento(date("Y-m-d H:m:s", strtotime(str_replace('/', '-', $post['operationScheduleTime'] ))));
        $schedule->setSaida(date("Y-m-d H:m:s", strtotime(str_replace('/', '-', $post['operationExit'] ))));
        $schedule->setSeparacao($post['binSeparation']);
        $schedule->setShipmentId($post['shipmentId']);
        $schedule->setDoca($post['dock']);
        $schedule->setDo_s($post['dos']);
        $schedule->setCidade($post['city']);

        $cargaQtde = $post['pallets'] == null ? 0 : $post['pallets'];
        $schedule->setCargaQtde($cargaQtde);
        $schedule->setObservacao($post['observation']);
        $schedule->setDadosGerais($post['material']);
        $schedule->setCliente($_SESSION['customerName']);

        return $schedule;
    }

    public function loadData($records){

        $schedules = array();

        while ($data = $records->fetch_assoc()){ 
            $schedule = new Schedule();
            $schedule->setId($data['id']);
            $schedule->setTransportadora($data['transportadora']);
            $schedule->setTipoVeiculo($data['tipoVeiculo']);
            $schedule->setPlacaCavalo($data['placa_cavalo']);
            $schedule->setOperacao($data['operacao']);
            $schedule->setNf($data['nf']);
            $schedule->setHoraChegada( date("d/m/Y h:m:s", strtotime($data['horaChegada'])));
            $schedule->setInicioOperacao(date("d/m/Y h:m:s", strtotime($data['inicio_operacao'])));
            $schedule->setFimOperacao(date("d/m/Y H:m:s", strtotime($data['fim_operacao'])));
            $schedule->setNomeUsuario($data['usuario']);
            $schedule->setDataInclusao(date("d/m/Y h:m:s", strtotime($data['dataInclusao'])));
            $schedule->setPeso($data['peso']);
            $schedule->setDataAgendamento(date("d/m/Y h:m:s", strtotime($data['data_agendamento'])));
            $schedule->setSaida(date("d/m/Y h:m:s", strtotime($data['saida'])));
            $schedule->setSeparacao($data['separacao']);
            $schedule->setShipmentId($data['shipment_id']);
            $schedule->setDoca($data['doca']);
            $schedule->setDo_s($data['do_s']);
            $schedule->setCidade($data['cidade']);
            $schedule->setCargaQtde($data['carga_qtde']);
            $schedule->setObservacao($data['observacao']);
            $schedule->setDadosGerais($data['dados_gerais']);
            $schedule->setCliente($data['cliente']);
            $schedule->setStatus($data['status']);
            
            array_push($schedules, $schedule);
        }

        return $schedules;
    }
}

?>