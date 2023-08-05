
<?php
class ScheduleRepository{

    private $mySql;

    public function __construct($mySql){
        $this->mySql = $mySql;
    }

    public function findAll(){

        try{
            $sql = "SELECT id,data_agendamento,transportadora,status,tipoVeiculo,placa_cavalo,operacao,nf,horaChegada,inicio_operacao,fim_operacao,usuario,dataInclusao,peso,saida,separacao,shipment_id,do_s,cidade,carga_qtde,observacao,dados_gerais,cliente,doca, nome_motorista, placa_carreta2, documento_motorista, placa_carreta
                    FROM janela";  

            $result = $this->mySql->query($sql);

            return $result;

        }catch(Exception $e){
            return false;
        }
    }

    public function findByClient($client){

        try{
            $sql = "SELECT id,data_agendamento,transportadora,status,tipoVeiculo,placa_cavalo,operacao,nf,horaChegada,inicio_operacao,fim_operacao,usuario,dataInclusao,peso,saida,separacao,shipment_id,do_s,cidade,carga_qtde,observacao,dados_gerais,cliente,doca, nome_motorista, placa_carreta2, documento_motorista, placa_carreta
                    FROM janela
                    WHERE cliente = '".$client."'
                    ORDER BY data_agendamento";  

            return $this->mySql->query($sql);

        }catch(Exception $e){
            return false;
        }
    }

    public function findByClientStartDateAndEndDate($client, $startDate, $endDate){

        try{
            $sql = "SELECT id,data_agendamento,transportadora,status,tipoVeiculo,placa_cavalo,operacao,nf,horaChegada,inicio_operacao,fim_operacao,usuario,dataInclusao,peso,saida,separacao,shipment_id,do_s,cidade,carga_qtde,observacao,dados_gerais,cliente,doca, nome_motorista, placa_carreta2, documento_motorista, placa_carreta
                    FROM janela
                    WHERE cliente = '".$client."'
                    AND data_agendamento >= '".$startDate."'
                    AND data_agendamento <= '".$endDate."'
                    ORDER BY data_agendamento";  

            return $this->mySql->query($sql);

        }catch(Exception $e){
            return false;
        }
    }

    public function findByClientStatusStartDateAndEndDate($client, $status, $startDate, $endDate){

        try{
            $sql = "SELECT id,data_agendamento,transportadora,status,tipoVeiculo,placa_cavalo,operacao,nf,horaChegada,inicio_operacao,fim_operacao,usuario,dataInclusao,peso,saida,separacao,shipment_id,do_s,cidade,carga_qtde,observacao,dados_gerais,cliente,doca, nome_motorista, placa_carreta2, documento_motorista, placa_carreta
                    FROM janela
                    WHERE cliente = '".$client."'
                    AND status = '".$status."' 
                    AND data_agendamento >= '".$startDate."'
                    AND data_agendamento <= '".$endDate."'
                    ORDER BY data_agendamento";  

            return $this->mySql->query($sql);

        }catch(Exception $e){
            return false;
        }
    }

    public function findById($id){

        try{
            $sql = "SELECT id,data_agendamento,transportadora,status,tipoVeiculo,placa_cavalo,operacao,nf,horaChegada,inicio_operacao,fim_operacao,usuario,dataInclusao,peso,saida,separacao,shipment_id,do_s,cidade,carga_qtde,observacao,dados_gerais,cliente,doca, nome_motorista, placa_carreta2, documento_motorista, placa_carreta
                    FROM janela
                    WHERE id = '".$id."'";  

            return $this->mySql->query($sql);

        }catch(Exception $e){
            return false;
        }
    }

    public function delete($id){

        try {
            $sql = "DELETE FROM janela WHERE Id = ".$id; 
            $this->mySql->query($sql);
            return 'DELETED';

        } catch (Exception $e) {
            return 'DELETE_ERROR';
        }
    }

    public function save($schedule){

        try{
            $sql = "INSERT INTO janela SET "; 
            if(!empty($schedule->getDataAgendamento())) $sql .= "data_agendamento = '".$schedule->getDataAgendamento()."',";
            $sql .= "transportadora = '".$schedule->getTransportadora()."',";
            $sql .= "status = '".$schedule->getStatus()."',";
            $sql .= "tipoVeiculo = '".$schedule->getTipoVeiculo()."',";
            $sql .= "placa_cavalo = '".$schedule->getPlacaCavalo()."',";
            $sql .= "operacao = '".$schedule->getOperacao()."',";
            $sql .= "nf = '".$schedule->getNf()."',";
            if(!empty($schedule->getHoraChegada()))  $sql .= "horaChegada = '".$schedule->getHoraChegada()."',";
            if(!empty($schedule->getInicioOperacao())) $sql .= "inicio_operacao = '".$schedule->getInicioOperacao()."',";
            if(!empty($schedule->getFimOperacao())) $sql .= "fim_operacao = '".$schedule->getFimOperacao()."',";
            $sql .= "usuario = '".$schedule->getNomeusuario()."',";
            $sql .= "dataInclusao = '".$schedule->getDataInclusao()."',";
            $sql .= "peso = '".$schedule->getPeso()."',";
            if(!empty($schedule->getSaida())) $sql .= "saida = '".$schedule->getSaida()."',";
            $sql .= "separacao = '".$schedule->getSeparacao()."',";
            $sql .= "shipment_id ='".$schedule->getShipmentId()."',";
            $sql .= "do_s = '".$schedule->getDo_s()."',";
            $sql .= "cidade = '".$schedule->getCidade()."',";
            $sql .= "carga_qtde = ".$schedule->getCargaQtde().",";
            $sql .= "observacao = '".$schedule->getObservacao()."',";
            $sql .= "dados_gerais = '".$schedule->getDadosGerais()."',";
            $sql .= "cliente = '".$schedule->getCliente()."',";
            $sql .= "doca = '".$schedule->getDoca()."',";
            $sql .= "nome_motorista = '".$schedule->getNomeMotorista()."',";
            $sql .= "placa_carreta2 = '".$schedule->getPlacaCarreta2()."',";
            $sql .= "documento_motorista = '".$schedule->getDocumentoMotorista()."',";
            $sql .= "placa_carreta = '".$schedule->getPlacaCarreta()."'";

            $result = $this->mySql->query($sql);

            if(!$result) return 'SAVE_ERROR';

            return $this->mySql->insert_id;

        }catch(Exception $e){
            return 'SAVE_ERROR';
        }
    }

    public function updateById($schedule, $id){

        try{
            $sql = "UPDATE janela SET ";
            if(!empty($schedule->getDataAgendamento())) $sql .= "data_agendamento = '".$schedule->getDataAgendamento()."',";
            $sql .= "transportadora = '".$schedule->getTransportadora()."',";
            $sql .= "status = '".$schedule->getStatus()."',";
            $sql .= "tipoVeiculo = '".$schedule->getTipoVeiculo()."',";
            $sql .= "placa_cavalo = '".$schedule->getPlacaCavalo()."',";
            $sql .= "operacao = '".$schedule->getOperacao()."',";
            $sql .= "nf = '".$schedule->getNf()."',";
            if(!empty($schedule->getHoraChegada())) $sql .= "horaChegada = '".$schedule->getHoraChegada()."',";
            if(!empty($schedule->getInicioOperacao())) $sql .= "inicio_operacao = '".$schedule->getInicioOperacao()."',";
            if(!empty($schedule->getFimOperacao())) $sql .= "fim_operacao = '".$schedule->getFimOperacao()."',";
            $sql .= "usuario = '".$schedule->getNomeusuario()."',";
            $sql .= "peso = '".$schedule->getPeso()."',";
            if(!empty($schedule->getSaida())) $sql .= "saida = '".$schedule->getSaida()."',";
            $sql .= "separacao = '".$schedule->getSeparacao()."',";
            $sql .= "shipment_id ='".$schedule->getShipmentId()."',";
            $sql .= "do_s = '".$schedule->getDo_s()."',";
            $sql .= "cidade = '".$schedule->getCidade()."',";
            $sql .= "carga_qtde = ".$schedule->getCargaQtde().",";
            $sql .= "observacao = '".$schedule->getObservacao()."',";
            $sql .= "dados_gerais = '".$schedule->getDadosGerais()."',";
            $sql .= "cliente = '".$schedule->getCliente()."',";
            $sql .= "doca = '".$schedule->getDoca()."',";
            $sql .= "nome_motorista = '".$schedule->getNomeMotorista()."', ";
            $sql .= "placa_carreta2 = '".$schedule->getPlacaCarreta2()."',";
            $sql .= "documento_motorista = '".$schedule->getDocumentoMotorista()."',";
            $sql .= "placa_carreta = '".$schedule->getPlacaCarreta()."'";
            $sql .= "WHERE ID = ".$id;  

            $result = $this->mySql->query($sql);
            return 'UPDATED';

        }catch(Exception $e){
            return 'SAVE_ERROR';
        }
    }
}
?>