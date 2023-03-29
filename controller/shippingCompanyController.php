<?php

require_once('../repository/shippingCompanyRepository.php');
require_once('../model/shippingCompany.php');

class ShippingCompanyController{

    private $shippingCompany;
    private $shippingCompanyRepository;
    private $mySql;

    public function __construct($mySql){

        $this->mySql = $mySql;
        $this->shippingCompanyRepository = new ShippingCompanyRepository($this->mySql);
    }

    public function findByClient($clientName){

        $result = $this->shippingCompanyRepository->findByClient($clientName);
        $data = $this->loadData($result);

        return $data;
    }

    public function loadData($records){

        $shippingCompanys = array();

        while ($data = $records->fetch_assoc()){ 
            $shippingCompany = new ShippingCompany();
            $shippingCompany->setId($data['id']);
            $shippingCompany->setNome($data['nome']);
            $shippingCompany->setUsername($data['username']);
            $shippingCompany->setCNPJ($data['cnpj']);
            $shippingCompany->setEmail($data['email']);
            $shippingCompany->setTelefone($data['telefone']);
            $shippingCompany->setCelular($data['celular']);
            $shippingCompany->setPassword($data['password']);
            $shippingCompany->setData($data['data']);
            $shippingCompany->setUsuario($data['usuario']);
            $shippingCompany->setClienteOrigem($data['cliente_origem']);
            
            array_push($shippingCompanys, $shippingCompany);
        }

        return $shippingCompanys;
    }
}

?>