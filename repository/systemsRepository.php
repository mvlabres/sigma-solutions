<?php

class SystemsRepository{

    private $mySql;

    public function __construct($mySql){
        $this->mySql = $mySql;
    }

    public function findByUser($userId){

        try{
            $sql = "SELECT systems.id AS systemId, name, description, systemUrl, iconPath
                    FROM systems 
                    INNER JOIN usersystems ON systems.id = usersystems.systemsId
                    WHERE usersystems.userId = " . $userId;  
                    
            $result = $this->mySql->query($sql);

            return $result;

        }catch(Exception $e){
            return false;
        }
    }
}

?>