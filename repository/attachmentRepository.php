
<?php
class AttachmentRepository{

    private $mySql;

    public function __construct($mySql){
        $this->mySql = $mySql;
    }

    public function findByScheduleId($scheduleId){

        try{
            $sql = "SELECT id, path, scheduleId, created_by, created_date
                    FROM attachment
                    WHERE scheduleId = ".$scheduleId;  

            $result = $this->mySql->query($sql);

            return $result;

        }catch(Exception $e){
            return false;
        }
    }

    public function save($scheduleId, $path){

        try{
            $sql = "INSERT INTO attachment
                    SET 
                    scheduleId = '".$scheduleId."',
                    created_by = '".$_SESSION['nome']."',
                    created_date = '".date('Y-m-d H:i:s')."',
                    path = '".$path."'";  

            $result = $this->mySql->query($sql);
            return 'SAVED';

        }catch(Exception $e){
            return 'SAVE_ERROR';
        }
    }

    public function deleteByCondition($condition){

        try{
            $sql = "DELETE FROM attachment
                    WHERE id IN (".$condition.")";  

            $result = $this->mySql->query($sql);
            return 'DELETED';

        }catch(Exception $e){
            return 'DELETE_ERROR';
        }
    }
}
?>