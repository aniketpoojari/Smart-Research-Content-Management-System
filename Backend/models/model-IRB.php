<?php

require_once '../database/connection.php';

class ModelIRB
{ 

    public function viewProposals()
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from documents where document_status = 4 and document_description like 'proposal';";
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



    public function viewDocumentsPerProject($projectID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from documents where project_ID like '$projectID';";
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

    public function approveProposals($projectID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $data1=array('status'=>'false');
        $sql="update documents set document_status = 5 where project_ID like '$projectID' and document_description like 'proposal';";
        $sql1="update dates_of_everything set approval = CURRENT_DATE where project_ID like '$projectID';";
        $result=$conn->query($sql);
        if($result === TRUE)
        {
            $data=array('status1'=>'true');
            $result1=$conn->query($sql1);
            if($result1===TRUE)
            {
                $data1=array('status'=>'true');
                return array_merge($data,$data1);
            }
        }
        else{
        }
        return $data;



        #now send the mail over here and make sure the Document is not a form anymore
    }

    

    public function disapproveProposals($projectID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="update documents set document_status = 0 where project_ID like '$projectID' and document_description like 'proposal';";
        $result=$conn->query($sql);
        if($result === TRUE)
        {
            $data=array('status1'=>'true');
        }
        else{
        }
        return $data;


        #now we write the function for mailing student and guide and sending the query letters
    }

    public function dropProposals($projectID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $data1=array('status'=>'false');
        $sql="update documents set document_status = -1 where project_ID like '$projectID' and document_description like 'proposal';";
        $sql1="update projects set completed = -1 where project_ID like '$projectID';";
        $result=$conn->query($sql);
        if($result === TRUE)
        {
            $data=array('status1'=>'true');
            $result1=$result=$conn->query($sql1);
        }
        else{
        }
        return $data;
    }

    public function viewMinutes($projectID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select document from documents where project_ID like '$projectID' and document_description like 'minutes' and document_status = 0;";
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
    
    public function approveMinutes($projectID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="update documents set document_status = 1 where document_description like 'minutes' and project_ID like '$projectID';";
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
?>