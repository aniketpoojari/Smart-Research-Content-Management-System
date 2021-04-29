<?php

require_once '../database/connection.php';

class ModelGuide
{ 
    public function approveProposals($guideID,$timestamp,$studentID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $data1 = array('status2'=>'false');
        $sql="update documents set document_status = 1 where student_ID like (select student_ID from students where guide_ID like '$guideID' and student_ID like '$studentID') and document_description like 'proposal' and submission_time like '$timestamp' and project_ID like 'PD0';";
        $sql1 = "update documents set document_status = 3 where student_ID like (select student_ID from students where guide_ID like '$guideID' and student_ID like '$studentID') and document_description like 'proposal' and submission_time like '$timestamp' and project_ID not like 'PD0';";
        $result=$conn->query($sql);
        if($result === TRUE)
        {
            $data=array('status1'=>'true');
        }
        else{
        }
        $result1 = $conn->query($sql1);
        if($result1 === TRUE)
        {
            $data1=array('status2'=>'true');
        }
        else{
        }
        return array_merge($data,$data1);
    }

    public function viewProposals($guideID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from documents where student_ID in (select student_ID from students where guide_ID like '$guideID') and document_description like 'Proposal';";
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

    public function viewProposalWithTime($studentID,$timestamp)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from documents where student_ID like '$studentID' and submission_time = '$timestamp';";
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

    public function viewPrincipleProjects($guideID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from projects where guide_ID like '$guideID' and completed > 0;";
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

    public function viewParticipatingProjects($guideID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from projects,project_guide_mapping where projects.project_ID = project_guide_mapping.project_ID and project_guide_mapping.guide_ID = '$guideID' and project_ID not 'PD0' and completed > 0;";
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

    public function viewPrincipleDocumentsPerProject($projectID,$guideID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select document,document_name,document_status,document_description,submission_time,project_ID,student_ID,ID from documents where project_ID in (select project_ID from projects where guide_ID like '$guideID') and project_ID like '$projectID' and document_description not like 'proposal';";
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

    public function approveDocuments($projectID,$description,$timestamp)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="update documents set document_status = 1 where document_description like '$description' and project_ID like '$projectID' and submission_time like '$timestamp';";
        $result=$conn->query($sql);
        if($result === TRUE)
        {
            $data=array('status1'=>'true');
        }
        else{
        }
        return $data;
    }

    public function viewApprovedProposals($guideID,$timestamp)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from documents where student_ID in (select student_ID from student_guide_mapping where guide_ID like '$guideID') and submission_time like '$timestamp' and document_description like 'proposal' and document_status > 1;";
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

    public function editDocuments($document,$studentID,$documentname,$timestamp)
    {
        global $conn;
        $data=array('status1'=>'false');
        //$data1=array('status2' => 'false');
        //$sql1 = "insert into editted_changes(document,time,document_name,student_ID) values('$document','CURRENT_TIMESTAMP','$documentname','$studentID');";
        $sql="update documents set document = '$document', edition_time = 'CURRENT_TIMESTAMP' where student_ID like '$studentID' and document_name like '$documentname' and submission_time like '$timestamp';";
        $result=$conn->query($sql);
        if($result === TRUE)
        {
            $data=array('status1'=>'true');
            return $data;
        }
        else{
            return $data;
        }
        
    }

    public function viewProjectDocuments($projectID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from documents where project_ID = '$projectID' and document_description <> 'proposal';";
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



}
?>

