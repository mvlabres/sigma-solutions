<?php
class ShippingCompanyRepository{

    private $mySql;

    public function __construct($mySql){
        $this->mySql = $mySql;
    }

    public function findByClient($clientName){

        try{
            $sql = "SELECT id, nome, username, cnpj, email, telefone, password, data, usuario, celular, cliente_origem 
                    FROM transportadora 
                    WHERE cliente_origem = '" .$clientName."'";  
                    
            $result = $this->mySql->query($sql);

            return $result;

        }catch(Exception $e){
            return false;
        }
    }
}

?>
