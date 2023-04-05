
<?php
class ScheduleRepository{

    private $mySql;

    public function __construct($mySql){
        $this->mySql = $mySql;
    }

    /*public function findAll(){

        try{
            $sql = "SELECT id, name, label
                    FROM operation_type";  

            $result = $this->mySql->query($sql);

            return $result;

        }catch(Exception $e){
            return false;
        }
    }*/

    /*public function findByName($name){

        try{
            $sql = "SELECT id, name, label
                    FROM operation_type
                    WHERE name = '".$name."'";  

            return $this->mySql->query($sql);

        }catch(Exception $e){
            return false;
        }
    }*/

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
                    doca = '".$schedule->getDoca()."'";

            $result = $this->mySql->query($sql);
            return 'SAVED';

        }catch(Exception $e){
            return 'SAVE_ERROR';
        }
    }

    // public function updateById($id, $name, $label){

    //     try{
    //         $sql = "UPDATE operation_type
    //                 SET name = '".$name."', label = '".$label."'
    //                 WHERE ID = ".$id;  

    //         $result = $this->mySql->query($sql);
    //         return 'UPDATED';

    //     }catch(Exception $e){
    //         return 'UPDATE_ERROR';
    //     }
    // }

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