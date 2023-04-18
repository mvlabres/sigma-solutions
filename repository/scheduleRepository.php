
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

    public function save($schedule){

        try{
            $sql = "INSERT INTO janela
                    SET 
                    data_agendamento = '".$schedule->getDataAgendamento()."',
                    transportadora = '".$schedule->getTransportadora()."',
                    status = '".$schedule->getStatus()."',
                    tipoVeiculo = '".$schedule->getTipoVeiculo()."',
                    placa_cavalo = '".$schedule->getPlacaCavalo()."',
                    operacao = '".$schedule->getOperacao()."',
                    nf = '".$schedule->getNf()."',
                    horaChegada = '".$schedule->getHoraChegada()."',
                    inicio_operacao = '".$schedule->getInicioOperacao()."',
                    fim_operacao = '".$schedule->getFimOperacao()."',
                    usuario = '".$schedule->getNomeusuario()."',
                    dataInclusao = '".$schedule->getDataInclusao()."',
                    peso = '".$schedule->getPeso()."',
                    saida = '".$schedule->getSaida()."',
                    separacao = '".$schedule->getSeparacao()."',
                    shipment_id ='".$schedule->getShipmentId()."',
                    do_s = '".$schedule->getDo_s()."',
                    cidade = '".$schedule->getCidade()."',
                    carga_qtde = ".$schedule->getCargaQtde().",
                    observacao = '".$schedule->getObservacao()."',
                    dados_gerais = '".$schedule->getDadosGerais()."',
                    cliente = '".$schedule->getCliente()."',
                    doca = '".$schedule->getDoca()."',
                    nome_motorista = '".$schedule->getNomeMotorista()."', 
                    placa_carreta2 = '".$schedule->getPlacaCarreta2()."',
                    documento_motorista = '".$schedule->getDocumentoMotorista()."',
                    placa_carreta = '".$schedule->getPlacaCarreta()."'";

            $result = $this->mySql->query($sql);
            return 'SAVED';

        }catch(Exception $e){
            return 'SAVE_ERROR';
        }
    }

    public function updateById($schedule, $id){

        try{
            $sql = "UPDATE janela
                    SET
                    data_agendamento = '".$schedule->getDataAgendamento()."',
                    transportadora = '".$schedule->getTransportadora()."',
                    status = '".$schedule->getStatus()."',
                    tipoVeiculo = '".$schedule->getTipoVeiculo()."',
                    placa_cavalo = '".$schedule->getPlacaCavalo()."',
                    operacao = '".$schedule->getOperacao()."',
                    nf = '".$schedule->getNf()."',
                    horaChegada = '".$schedule->getHoraChegada()."',
                    inicio_operacao = '".$schedule->getInicioOperacao()."',
                    fim_operacao = '".$schedule->getFimOperacao()."',
                    usuario = '".$schedule->getNomeusuario()."',
                    dataInclusao = '".$schedule->getDataInclusao()."',
                    peso = '".$schedule->getPeso()."',
                    saida = '".$schedule->getSaida()."',
                    separacao = '".$schedule->getSeparacao()."',
                    shipment_id ='".$schedule->getShipmentId()."',
                    do_s = '".$schedule->getDo_s()."',
                    cidade = '".$schedule->getCidade()."',
                    carga_qtde = ".$schedule->getCargaQtde().",
                    observacao = '".$schedule->getObservacao()."',
                    dados_gerais = '".$schedule->getDadosGerais()."',
                    cliente = '".$schedule->getCliente()."',
                    doca = '".$schedule->getDoca()."',
                    nome_motorista = '".$schedule->getNomeMotorista()."', 
                    placa_carreta2 = '".$schedule->getPlacaCarreta2()."',
                    documento_motorista = '".$schedule->getDocumentoMotorista()."',
                    placa_carreta = '".$schedule->getPlacaCarreta()."'
                    WHERE ID = ".$id;  


            $result = $this->mySql->query($sql);
            return 'UPDATED';

        }catch(Exception $e){
            return 'SAVE_ERROR';
        }
    }

    // public function deleteById($id){

    //     try{
    //         $sql = "DELETE FROM operation_type
    //                 WHERE id = ".$id;  

    //         $result = $this->mySql->query($sql);
    //         return 'DELETED';

    //     }catch(Exception $e){
    //         return 'DELETE_ERROR';
    //     }
    // }
}
?>