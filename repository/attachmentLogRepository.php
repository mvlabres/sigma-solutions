
<?php
class AttachmentLogRepository{

    private $mySql;

    public function __construct($mySql){
        $this->mySql = $mySql;
    }


    public function updateLastCreated($shipmentId, $qtdeRecords){

        try{
            $sql = "UPDATE attachment_log
                    SET user_action = '".$_SESSION['nome']."',
                    shipmentId = '".$shipmentId."'
                    ORDER BY id DESC LIMIT ".$qtdeRecords; 

            $result = $this->mySql->query($sql);
            return 'UPDATED';

        }catch(Exception $e){
            return 'UPDATE_ERROR';
        }
    }
}
?>