<?php
require_once '../database/connection.php';

class ModelRD
{
    #Function to select from documents
    public function viewDocuments()
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select * from documents order by project_ID ;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status'=>'true');
            $dataval=array('documents'=>$arr);
            #Check if Tanmay wants to merge dataval or arr directly
            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
    }


    #Function to view projects
    public function viewApprovedProjects()
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select * from projects order by project_ID;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status'=>'true');
            $dataval=array('projects'=>$arr);
            #Check if Tanmay wants to merge dataval or arr directly
            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found'); }
            return array_merge($data,$dataval);
    }

    #Function to view projects
    public function viewDispprovedProjects()
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select * from newprojects where feasible like '-1';";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status'=>'true');
            $dataval=array('projects'=>$arr);
            #Check if Tanmay wants to merge dataval or arr directly
            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found'); }
            return array_merge($data,$dataval);
    }

       #Function to view projects
       public function viewPendingProjects()
       {
           global $conn;
           $data = array('status'=>'false');
   
           $sql = "select * from newprojects where feasible like '0';";
           $result = $conn->query($sql);
   
           if ($result->num_rows > 0) {
               $arr = [];
               while($row = $result->fetch_assoc())
               {
                   array_push($arr,$row);
               }
               $data=array('status'=>'true');
               $dataval=array('projects'=>$arr);
               #Check if Tanmay wants to merge dataval or arr directly
               return array_merge($data,$dataval);
           } else{
               $dataval = array('result'=>'No Entries Found'); }
               return array_merge($data,$dataval);
       }

        #Function to select from finances
        public function viewFinances()
        {
            global $conn;
            $data=array('status'=>'false');

            $sql= "select * from finances order by project_ID;" ;
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

    #Update projects from new projects
    public function approveProjects($studentID,$derivedFrom,$projectName)
    {
        global $conn;
        $data=array('status'=>'false');
        $data1=array('status1'=>'false');
        $sql="update newprojects set feasible = 1 where student_ID = '$studentID' and derived_from = '$derivedFrom' and project_name='$projectName';";
        $result = $conn->query($sql);
        if ($result === TRUE) {
            $data=array('status'=>'true');
        } else { 
            $data=array('status'=>'false');
        }
        return $data;
    }

    #Accepting praposals from the deadlines table
    public function approveProposal($projectID,$description)
    {
        global $conn;
        $data=array('status'=>'false');
        if($description == "proposal")
        {
            $sql="update deadlines set $description = CURRENT_DATE where project_ID = '$projectID';";
            $result = $conn->query($sql);
            if ($result === TRUE) {
                $data=array('status'=>'true');
            } else { 
                $data=array('status'=>'false');
            }
            return $data;
        }
    }

    #Update projects from new projects
    public function disApproveProjects($studentID,$derivedFrom,$projectName)
    {
        global $conn;
        $data=array('status'=>'false');
        $data1=array('status1'=>'false');
        $sql="update newprojects set feasible = -1 where student_ID = '$studentID' and derived_from = '$derivedFrom' and project_name='$projectName';";
        $result = $conn->query($sql);
        if ($result === TRUE) {
            $data=array('status'=>'true');
        } else { 
            $data=array('status'=>'false');
        }
        return $data;
    }

    #NOT Accepting praposals from the deadlines table
    public function disapproveDocuments($projectID,$description)
    {
        global $conn;
        $data=array('status'=>'false');
        $data1=array('status1'=>'false');
        if($description == "proposal")
        {
           $sql="update deadlines set $description = '0' where project_ID = '$projectID';";
           $result2 = $conn->query($sql);
           if($result2 === TRUE){
                    $data1=array('status1'=>'true');
                }
                 else { 
                    $data1=array('status1'=>'false');
                }

           $sql7 = "select documents.document_ID from documents where documents.description like '$description' and documents.document_name != 'Rejected' and documents.project_ID like '$projectID';";
           $result = $conn->query($sql7);
    
            if ($result->num_rows > 0) {
                $arr = [];
                while($row = $result->fetch_assoc())
                    {
                        array_push($arr,$row);
                    }
                $var =  $arr[0]["document_ID"];

                $sql1="update documents set documents.document_name = 'Rejected' where documents.Document_ID = '$var';";
                $result1 = $conn->query($sql1);

                if($result1 === TRUE){
                    $data=array('status'=>'true');
                }
                 else { 
                    $data=array('status'=>'false');
                }
            return array_merge($data,$data1);
            }
        }
    }

#this ends here 
}