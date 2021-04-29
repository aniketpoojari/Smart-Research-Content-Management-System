<?php

require_once '../database/connection.php';

class ModelHR
{ 

    public function viewTenure()
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select student_ID,student_name,tenure_start,tenure_end from students";
        $result=$conn->query($sql);
        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status1'=>'true');
            $dataval=array('documents'=>$arr);
            #Check if Tanmay wants to merge dataval or arr directly
            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
    }

    public function extendTenure($studentID,$new_date)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="update students set tenure_end = '$new_date' where student_ID like '$studentID';";
        $result=$conn->query($sql);
        if($result === TRUE)
        {
            $data=array('status1'=>'true');
        }
        else{
        }
        return $data;
    }
}