<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

    public function setFields($post, $schedule){

        $schedule->setTransportadora($post['shippingCompany']);
        $schedule->setTipoVeiculo($post['truckType']);
        $schedule->setPlacaCavalo($post['licenceTruck']);
        $schedule->setOperacao($post['operationType']);
        $schedule->setNf($post['invoice']);
        $schedule->setHoraChegada($post['arrival']);
        $schedule->setInicioOperacao($post['operationStart']);
        $schedule->setFimOperacao($post['operationDone']);
        $schedule->setNomeUsuario($_SESSION['nome']);
        $schedule->setDataInclusao(date("d-m-Y h:m:s"));
        $schedule->setPeso($post['grossWeight']);
        $schedule->setDataAgendamento($post['operationScheduleTime']);
        $schedule->setSaida($post['operationExit']);
        $schedule->setSeparacao($post['binSeparation']);
        $schedule->setShipmentId($post['shipmentId']);
        $schedule->setDo_s($post['dos']);
        $schedule->setCidade($post['city']);
        $schedule->setCargaQtde($post['pallets']);
        $schedule->setObservacao($post['observation']);
        $schedule->setDadosGerais($post['material']);
        $schedule->setCliente($_SESSION['customerName']);

        return $schedule;
    }

    // public function findByName($customerName){

    //     $result = $this->customerRepository->findByName($customerName);
    //     $data = $this->loadData($result);

    //     if(count($data) > 0) return $data;

    //     return null;
    // }

    // public function loadData($records){

    //     $customers = array();

    //     while ($data = $records->fetch_assoc()){ 
    //         $customer = new Customer();
    //         $customer->setId($data['id']);
    //         $customer->setName($data['name']);
    //         $customer->setDescription($data['description']);
            
    //         array_push($customers, $customer);
    //     }

    //     return $customers;
    // }
}

?>