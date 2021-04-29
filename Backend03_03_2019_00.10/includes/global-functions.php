<?php
require_once "../database/connection.php";
class GlobalFunctions
{
    public function viewAllProjects()
    {
        global $conn;
        $data=array('status'=>'false');

        $sql="select * from projects;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status'=>'true');
            $dataval=array('finances'=>$arr);
            #Check if Tanmay wants to merge dataval or arr directly
            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }    
    }
}