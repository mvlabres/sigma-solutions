
<?php
class TruckTypeRepository{

    private $mySql;

    public function __construct($mySql){
        $this->mySql = $mySql;
    }

    public function findAll(){

        try{
            $sql = "SELECT id, descricao
                    FROM tipoveiculo";  

            $result = $this->mySql->query($sql);

            return $result;

        }catch(Exception $e){
            return false;
        }
    }

    public function findByDescription($description){

        try{
            $sql = "SELECT id, descricao
                    FROM tipoveiculo
                    WHERE descricao = '".$description."'";  

            return $this->mySql->query($sql);

        }catch(Exception $e){
            return false;
        }
    }

    public function save($post){

        try{
            $sql = "INSERT INTO tipoveiculo
                    SET descricao = '".$post['description']."'";  

            $result = $this->mySql->query($sql);
            return 'SAVED';

        }catch(Exception $e){
            return 'SAVE_ERROR';
        }
    }

    public function deleteById($id){

        try{
            $sql = "DELETE FROM tipoveiculo
                    WHERE id = ".$id;  

            $result = $this->mySql->query($sql);
            return 'DELETED';

        }catch(Exception $e){
            return 'DELETE_ERROR';
        }
    }
}
?>