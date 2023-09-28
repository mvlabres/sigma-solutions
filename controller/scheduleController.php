<?php

require_once('../repository/scheduleRepository.php');
require_once('../model/schedule.php');
require_once('../model/columnsPreference.php');
require_once('../repository/columnsPreferencesRepository.php');
require_once('../repository/attachmentRepository.php');

class ScheduleController{

    private $schedule;
    private $scheduleRepository;
    private $attachmentRepository;
    private $mySql;

    public function __construct($mySql){

        $this->mySql = $mySql;
        $this->scheduleRepository = new ScheduleRepository($this->mySql);
        $this->attachmentRepository = new AttachmentRepository($this->mySql);
    }

    public function save($post){

        try {

            $schedule = new Schedule();
            $schedule->setStatus('Agendado'); 
            
            $schedule = $this->setFields($post, $schedule);

            $result = $this->scheduleRepository->save($schedule);

            if($result == 'SAVE_ERROR') return $result;

            return $this->saveFiles($result, 'SAVED');  
            
        } catch (Exception $e) {

            $description = $e->getMessage() . '- ' . $e->getTraceAsString();

            $description = str_replace('\'', '"', $description);
            
            echo $description;
    
            return 'SAVE_ERROR';
        }
    }

    public function delete($id){
        return $this->scheduleRepository->delete($id);
    }

    public function update($post){

        try {

            $schedule = new Schedule();
            $schedule->setStatus($post['scheduleStatus']); 

            $schedule = $this->setFields($post, $schedule);
            $result =  $this->scheduleRepository->updateById($schedule, $post['id']);
            
            if($result == 'SAVE_ERROR') return $result;

            if($post['filesToRemove'] != '') $this->deleteAttachment($post['filesToRemove']);

            if($result == 'DELETE_ERROR') throw new Exception("Erro ao deletar anexos", 1);

            return $this->saveFiles($schedule->getId(), 'UPDATED'); 
        
        } catch (Exception $e) {
            return 'SAVE_ERROR';
        }
    }

    public function deleteAttachment($idsString){

        print_r($idsString);

        $result = $this->attachmentRepository->deleteByCondition(str_replace(';', ',', $idsString));
    }

    public function findByClient($client){

        $result = $this->scheduleRepository->findByClient($client);
        $data = $this->loadData($result);

        return $data;
    }

    public function findByClientStatusStartDateAndEndDate($client, $status, $startDate, $endDate){

        $startDate = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $startDate )));
        $endDate = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $endDate )));

        if($status == 'Todos'){
            $result = $this->scheduleRepository->findByClientStartDateAndEndDate($client, $startDate, $endDate);
        }else {
            $result = $this->scheduleRepository->findByClientStatusStartDateAndEndDate($client, $status, $startDate, $endDate);
        }

        $data = $this->loadDataByNameValue($result);

        return $data;
    }

    public function findById($id){

        $result = $this->scheduleRepository->findById($id);
        $data = $this->loadData($result);

        $data[0] = $this->findAttByScheduleId($data[0]);

        if(count($data) > 0) return $data[0];

        return $data;
    }

    public function saveFiles($scheduleId, $action){

        $countfiles = count($_FILES['file']['name']);

        try {
            for($i=0;$i<$countfiles;$i++){
    
                $fileName =  $_FILES['file']['name'][$i];
    
                $scheduleDirectory = 'files/schedule_'.$scheduleId.'/';
    
                if (!file_exists($scheduleDirectory)) mkdir($scheduleDirectory, 0755);
                
                $tempName = $_FILES['file']['tmp_name'][$i];
                $pathFile = $scheduleDirectory.$fileName;

                if (!file_exists($pathFile)) {
                    move_uploaded_file($tempName,$pathFile);
                    $this->attachmentRepository->save($scheduleId, $pathFile);
                }
            }

            return $action;

        } catch (Exception $e) {
            return 'SAVE_ERROR';
        }
    }

    public function savePreferences($columnsDefault, $post){

        $columnsPreference = $post['column'];

        $id = $post['preferenceId'];

        $columnsToSave = array();
        $cont = 0;

        foreach ($columnsDefault as $key => $value) {
            
            $value['show'] = false;
            $value['order'] = $cont + 200;

            $columnsToSave[$key] = $value;
            $cont++;
        }

        $cont = 0;
        foreach ($columnsPreference as $value) {
            
            $column = $columnsToSave[$value];

            $column['show']  = true;
            $column['order'] = $cont;

            $columnsToSave[$value] = $column;
            $cont++;
        }

        $columnsPreference = new ColumnsPreference();
        $columnsPreferencesRepository = new ColumnsPreferencesRepository($this->mySql);

        $columnsPreference->setUserId($_SESSION['id']);
        $columnsPreference->setPreference( json_encode($columnsToSave, JSON_UNESCAPED_UNICODE));

        if($id == null){
            return $columnsPreferencesRepository->save($columnsPreference);
        }

        return $columnsPreferencesRepository->updateById($columnsPreference, $id);

    }

    public function findPreferenceByUser(){

        $columnsPreferencesRepository = new ColumnsPreferencesRepository($this->mySql);
        $result = $columnsPreferencesRepository->findByUser($_SESSION['id']);

        if($result->num_rows == 0) return new ColumnsPreference();

        return $this->loadPreferenceData($result);
    }

    public function sortArray($columns){

        $ordenedColumns = array();

        $cont = 0;
        foreach ($columns as $key => $value){

            $ordenedColumns[$cont] = $value['order'];
            $cont++; 
        }

        array_multisort($ordenedColumns, SORT_ASC, $columns);

        return $columns;
    }

    public function findAttByScheduleId($schedule){

        $result = $this->attachmentRepository->findByScheduleId($schedule->getId());

        $paths = array();

        while ($data = $result->fetch_assoc()){ 

            $paths[$data['id']] = $data['path'];
        }
        
        $schedule->setFilesPath($paths);
        return $schedule;
    }

    public function setFields($post, $schedule){

        if($post['id'] && $post['id'] != null) $schedule->setId($post['id']);
        $schedule->setTransportadora($post['shippingCompany']);
        $schedule->setTipoVeiculo($post['truckType']);
        $schedule->setPlacaCavalo($post['licenceTruck']);
        $schedule->setOperacao($post['operationType']);
        $schedule->setNf($post['invoice']);
        $schedule->setHoraChegada(date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $post['arrival'] ))));
        if($post['arrival'] == '') $schedule->setHoraChegada('');

        $schedule->setInicioOperacao(date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $post['operationStart'] ))));
        if($post['operationStart'] == '') $schedule->setInicioOperacao('');

        $schedule->setFimOperacao(date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $post['operationDone'] ))));
        if($post['operationDone'] == '') $schedule->setFimOperacao('');

        $schedule->setNomeUsuario($_SESSION['nome']);
        $schedule->setDataInclusao(date("Y-m-d H:i:s"));
        $schedule->setPeso($post['grossWeight']);
        $schedule->setDataAgendamento(date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $post['operationScheduleTime'] ))));

        $schedule->setSaida(date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $post['operationExit'] ))));
        if($post['operationExit'] == '') $schedule->setSaida('');

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

        $schedule->setNomeMotorista($post['driverName']); 
        $schedule->setPlacaCarreta2($post['licenceTrailer2']);
        $schedule->setDocumentoMotorista($post['documentDriver']);
        $schedule->setPlacaCarreta($post['licenceTrailer']);

        return $schedule;
    }

    public function loadPreferenceData($records){

        while ($data = $records->fetch_assoc()){ 
            $columnsPreference = new ColumnsPreference();
            $columnsPreference->setId($data['id']);
            $columnsPreference->setPreference($data['preference']);
            $columnsPreference->setUserId($data['userId']);
        }

        return $columnsPreference;
    }

    public function loadDataByNameValue($records){

        $schedules = array();

        while ($data = $records->fetch_assoc()){ 


            $schedule['getId'] = $data['id'];
            $schedule['getTransportadora'] = $data['transportadora'];
            $schedule['getTipoVeiculo'] = $data['tipoVeiculo'];
            $schedule['getPlacaCavalo'] = $data['placa_cavalo'];
            $schedule['getOperacao'] = $data['operacao'];
            $schedule['getNf'] = $data['nf'];
            $schedule['getHoraChegada'] = date("d/m/Y H:i:s", strtotime($data['horaChegada']));
            if(empty($data['horaChegada'])) $schedule['getHoraChegada'] = '';

            $schedule['getInicioOperacao'] = date("d/m/Y H:i:s", strtotime($data['inicio_operacao']));
            if(empty($data['inicio_operacao'])) $schedule['getInicioOperacao'] = '';

            $schedule['getFimOperacao'] = date("d/m/Y H:i:s", strtotime($data['fim_operacao']));
            if(empty($data['fim_operacao'])) $schedule['getFimOperacao'] = '';

            $schedule['getNomeUsuario'] = $data['usuario'];
            $schedule['getDataInclusao'] = date("d/m/Y H:i:s", strtotime($data['dataInclusao']));
            $schedule['getPeso'] = $data['peso'];
            $schedule['getDataAgendamento'] = date("d/m/Y H:i:s", strtotime($data['data_agendamento']));
            $schedule['getSaida'] = date("d/m/Y H:i:s", strtotime($data['saida']));
            if(empty($data['saida'])) $schedule['getSaida'] = '';

            $schedule['getSeparacao'] = $data['separacao'];
            $schedule['getShipmentId'] = $data['shipment_id'];
            $schedule['getDoca'] = $data['doca'];
            $schedule['getDo_s'] = $data['do_s'];
            $schedule['getCidade'] = $data['cidade'];
            $schedule['getCargaQtde'] = $data['carga_qtde'];
            $schedule['getObservacao'] = $data['observacao'];
            $schedule['getDadosGerais'] = $data['dados_gerais'];
            $schedule['getCliente'] = $data['cliente'];
            $schedule['getStatus'] = $data['status'];
            $schedule['getNomeMotorista'] = $data['nome_motorista']; 
            $schedule['getPlacaCarreta2'] = $data['placa_carreta2'];
            $schedule['getDocumentoMotorista'] = $data['documento_motorista'];
            $schedule['getPlacaCarreta'] = $data['placa_carreta'];
            
            array_push($schedules, $schedule);
        }

        return $schedules;
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
            $schedule->setHoraChegada( date("d/m/Y H:i:s", strtotime($data['horaChegada'])));
            if(empty($data['horaChegada'])) $schedule->setHoraChegada('');

            $schedule->setInicioOperacao(date("d/m/Y H:i:s", strtotime($data['inicio_operacao'])));
            if(empty($data['inicio_operacao'])) $schedule->setInicioOperacao('');

            $schedule->setFimOperacao(date("d/m/Y H:i:s", strtotime($data['fim_operacao'])));
            if(empty($data['fim_operacao'])) $schedule->setFimOperacao('');

            $schedule->setNomeUsuario($data['usuario']);
            $schedule->setDataInclusao(date("d/m/Y H:i:s", strtotime($data['dataInclusao'])));
            $schedule->setPeso($data['peso']);
            $schedule->setDataAgendamento(date("d/m/Y H:i:s", strtotime($data['data_agendamento'])));
            $schedule->setSaida(date("d/m/Y H:i:s", strtotime($data['saida'])));
            if(empty($data['saida'])) $schedule->setSaida('');

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
            $schedule->setNomeMotorista($data['nome_motorista']); 
            $schedule->setPlacaCarreta2($data['placa_carreta2']);
            $schedule->setDocumentoMotorista($data['documento_motorista']);
            $schedule->setPlacaCarreta($data['placa_carreta']);
    
            array_push($schedules, $schedule);
        }

        return $schedules;
    }

    public function getIdLastError(){
    
        $result = $this->scheduleRepository->getLastError();
        $id = '';

        while ($data = $result->fetch_assoc()){ 
           $id = $data['id'];
        }

        return $id;
    }
}

?>