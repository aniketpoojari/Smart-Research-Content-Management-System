<?php
require_once "../database/connection.php";

class ModelHR
{
    public function addStudents($studentID,$studentName)
    {
        global $conn;
        $data=array('status'=>'false');
        $sql1="insert into student values('$studentID','$studentName',NULL);";
        $result = $conn->query($sql1);
    
        if ($result === TRUE) {
            $data=array('status'=>'true');
            return $data;
        } else {
            return $data;
        }
    }

    public function addGuides($guideID,$guideName)
    {
        global $conn;
        $data=array('status'=>'false');
        $sql1="insert into guides values('$guideID','$guideName');";
        $result = $conn->query($sql1);
    
        if ($result === TRUE) {
            $data=array('status'=>'true');
            return $data;
        } else {
            return $data;
        }
    }
    
    public function viewProjects()
    {
        global $conn;
        $data=array('status'=>'false');

        $sql="select * from projects order by project_ID";
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