<?php

require_once '../database/connection.php';

class ModelStudent
{
    public function addBudget($document,$documentname,$studentID)
    {
        global $conn;
        $data=array('status'=>'false');
        $data1 = array('status1'=>'false');

        $sql="insert into documents(document,document_name,document_status,document_description,submission_time,project_ID,student_ID) values('$document','$documentname',0,'budget',CURRENT_TIMESTAMP,'PD0','$studentID');";
        $sql1 = "insert into editted_changes(document,time, document_name, student_ID) values('$document',CURRENT_TIMESTAMP, '$documentname', '$studentID');";

        $result = $conn->query($sql);
        if ($result === TRUE) {
            $data=array('status'=>'true');
           // return $data;
        } else {
            $data=array('status'=>'false');
        }

        $result1 = $conn->query($sql1);
        if ($result1 === TRUE) {
            $data1=array('status1'=>'true');
           // return $data;
        } else {
            $data1=array('status1'=>'false');
        }

        return array_merge($data,$data1);
    }
    public function addProposals($document,$documentname,$studentID)
    {
        global $conn;
        $data=array('status'=>'false');
        $data1 = array('status1'=>'false');

        $sql="insert into documents(document,document_name,document_status,document_description,submission_time,project_ID,student_ID) values('$document','$documentname',0,'proposal',CURRENT_TIMESTAMP,'PD0','$studentID');";
        $sql1 = "insert into editted_changes(document,time, document_name, student_ID) values('$document',CURRENT_TIMESTAMP, '$documentname', '$studentID');";

        $result = $conn->query($sql);
        if ($result === TRUE) {
            $data=array('status'=>'true');
           // return $data;
        } else {
            $data=array('status'=>'false');
        }

        $result1 = $conn->query($sql1);
        if ($result1 === TRUE) {
            $data1=array('status1'=>'true');
           // return $data;
        } else {
            $data1=array('status1'=>'false');
        }

        return array_merge($data,$data1);
    }

    public function viewSubmittedProposals($studentID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select document,document_name,document_status,submission_time from documents where student_ID like '$studentID' and document_description = 'proposal';";
        $result = $conn->query($sql);
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

    public function viewProjects($studentID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from projects where project_ID in (select project_ID from project_student_mapping where student_ID like '$studentID');";
        $result = $conn->query($sql);
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

    public function viewGuides()
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from guides;";
        $result = $conn->query($sql);
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

    public function addPrincipleGuide($guideID,$studentID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $data1= array('status'=>'false');
        $sql="UPDATE students set guide_ID = '$guideID' where student_ID like '$studentID';";
        $sql1="insert into student_guide_mapping values('$studentID','$guideID')";
        $result = $conn->query($sql);
        $result1 = $conn->query($sql1);

        if ($result === TRUE) {
            $data=array('status'=>'true');
            //return $data;
        } else {
            //return $data;
        }
        if ($result1 === TRUE) {
            $data1=array('status'=>'true');
            return array_merge($data,$data1);
        } else {
            return array_merge($data,$data1);
        }

    }

    public function addOtherGuides($guideID,$studentID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="insert into student_guide_mapping values('$studentID','$guideID');";
        $result = $conn->query($sql);

        if ($result === TRUE) {
            $data=array('status'=>'true');
            return $data;
        } else {
            return $data;
        }
    }

    public function viewOwnGuides($studentID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from guides where guide_ID in (select guide_ID from student_guide_mapping where student_ID like '$studentID');";
        $result = $conn->query($sql);
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

    public function addDocuments($document,$documentname,$studentID,$description,$projectID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="insert into documents(document,document_name,document_status,document_description,submission_time,project_ID,student_ID) values('$document','$documentname',0,'$description',CURRENT_TIMESTAMP,'$projectID','$studentID');";
        $result = $conn->query($sql);
        if ($result === TRUE) {
            $data=array('status'=>'true');
            return $data;
        } else {
            return $data;
        }
    }

    public function getMaterials()
    {
        global $conn;
        $data = array('status1' => 'false');
        $sql = "select * from materials;";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row['materials']);
            }
            $data=array('status1'=>'true');
            $dataval = array('materials'=>$arr);
            #Check if Tanmay wants to merge dataval or arr directly
            return array_merge($data,$dataval);    
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
    }

    #function
    function fetchProjects($projectID)
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select * from projects where projects.project_ID like '$projectID';";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status'=>'true');
            $dataval=array('deadlines'=>$arr);
            #Check if Tanmay wants to merge dataval or arr directly
            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
    }

    function viewDocuments($projectID)
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select * from documents where project_ID like '$projectID';";
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

    public function viewBudget($studentID)
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select DOCUMENT,submission_time,document_status,document_name from documents where student_ID like '$studentID' and document_description like 'budget'; ";
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

    public function viewQueryLetters($projectID)
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select * from documents where project_ID like '$projectID' and document_desription like 'Query Letter';";
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

    public function viewSubmittedProposalwithTime($studentID,$submission_time)
    {
        global $conn;
        $data=array('status'=>'false');
        $data1=array('status1'=>'false');

        $sql="select document,document_status,document_name,submission_time from documents where student_ID like '$studentID' and document_description = 'proposal' and submission_time like '$submission_time';";
        $sql1 = "SELECT document FROM `editted_changes` WHERE time = '$submission_time' and student_ID = '$studentID'; ";
    
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status'=>'true');
            $dataval=array('updated'=>$arr);

        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            $arr1 = [];
            while($row = $result1->fetch_assoc())
            {
                array_push($arr1,$row);
            }
            $data1 = array('status1'=>'true');
            $dataval1 = array('to_compare'=>$arr1);
            
            #Check if Tanmay wants to merge dataval or arr directly
            return array_merge($data,$dataval,$data1,$dataval1);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        } 
    }  

    }

    public function viewSubmittedBudgetwithTime($studentID,$submission_time)
    {
        global $conn;
        $data=array('status'=>'false');
        $data1=array('status1'=>'false');
        $sql="select document,document_status from documents where student_ID like '$studentID' and document_description = 'budget' and submission_time like '$submission_time';";
        $sql1 = "SELECT document FROM `editted_changes` WHERE time = '$submission_time' and student_ID = '$studentID'; ";
    
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status'=>'true');
            $dataval=array('updated'=>$arr);

        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            $arr1 = [];
            while($row = $result1->fetch_assoc())
            {
                array_push($arr1,$row);
            }
            $data1 = array('status1'=>'true');
            $dataval1 = array('to_compare'=>$arr1);
            
            #Check if Tanmay wants to merge dataval or arr directly
            return array_merge($data,$dataval,$data1,$dataval1);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        } 
    }  

    }

    public function viewNotifications($studentID)
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select notifications.project_ID, notifications.message_time, notifications.message from notifications,project_student_mapping where project_student_mapping.project_ID = notifications.project_ID and student_ID = '$studentID' order by notifications.message_time asc LIMIT 5;"; 
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
        } else{
            $dataval = array('result'=>'No Entries Found');
        }

        return array_merge($data,$dataval);

    }

    public function viewAllNotifications($studentID)
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select notifications.project_ID, notifications.message_time, notifications.message from notifications,project_student_mapping where project_student_mapping.project_ID = notifications.project_ID and student_ID = '$studentID' order by notifications.message_time asc;"; 
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
        } else{
            $dataval = array('result'=>'No Entries Found');
        }

        return array_merge($data,$dataval);

    }

    public function editDocuments($document,$studentID,$documentname,$timestamp)
    {
        global $conn;
        $data=array('status1'=>'false');
        //$data1=array('status2' => 'false');
        //$sql1 = "insert into editted_changes(document,time,document_name,student_ID) values('$document','CURRENT_TIMESTAMP','$documentname','$studentID');";
        $sql="update documents set document = '$document', edition_time = CURRENT_TIMESTAMP where student_ID like '$studentID' and document_name like '$documentname' and submission_time like '$timestamp';";
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
}