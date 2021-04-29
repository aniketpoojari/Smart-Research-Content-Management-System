<?php
require_once '../database/connection.php';

class ModelSecretariat
{
    public function viewProposalBeforeDirector()
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from documents where document_description like 'proposal' and document_status = 1";
        $result=$conn->query($sql);
        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status1'=>'true');
            $dataval=array('documents'=>$arr);

            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
        $conn->close();
    }

    public function sendQueryLetters($document,$documentname,$projectID,$secretariatID)
    {
        global $conn;
        $data=array('status'=>'false');

        $sql="insert into documents(document,document_name,document_status,document_description,submission_time,project_ID,ID) values('$document','$documentname',0,'Query Letter',CURRENT_TIMESTAMP,'$projectID','$secretariatID');";
        $result = $conn->query($sql);

        if($data['status'] == 'true')
        {
            $conn->commit();
        }
        else
        {
            $conn->rollback();
        }

        if ($result === TRUE) {
            $data=array('status'=>'true');
            return $data;
        } else{
            return $data;
        }
        $conn->close();

    }
    public function viewProposalAfterDirector()
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from documents where document_description like 'proposal' and document_status = 3";
        $result=$conn->query($sql);
        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status1'=>'true');
            $dataval=array('documents'=>$arr);
            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
        $conn->close();

    }
    
    public function approveDocumentsBeforeDirector($studentID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="update documents set document_status = 2 where student_ID like '$studentID' and document_description like 'proposal';";
        $result=$conn->query($sql);

        if($result === TRUE)
        {
            $data=array('status1'=>'true');
            return $data;
        }
        else{
            return $data;
        }

        if($data['status'] == 'true')
        {
            $conn->commit();
        }
        else
        {
            $conn->rollback();
        }

        $conn->close();
    }

    public function addProjects($studentID,$projectID,$projectname,$guideID,$endDate)
    {
        global $conn;
        $data=array('status'=>'false');
        $data1=array('status1'=>'false');
        $data2=array('status2'=>'false');
        $data3 = array('status3' => 'false');
        
        $sql = "insert into projects(project_ID,project_name,completed,guide_ID) values('$projectID','$projectname',0,'$guideID');";
        $sql1 = "update documents set project_ID = '$projectID',document_status = 4 where student_ID like '$studentID' and document_description like 'proposal' and project_ID like 'PD0';";
        $sql2 = "insert into project_student_mapping(student_ID, project_ID) values('$studentID','$projectID');";
        $sql3 = "insert into dates_of_everything(project_ID,exp_completion) values('$projectID','$endDate');";

        $result = $conn->query($sql);
    
        if ($result === TRUE) {
            $data=array('status'=>'true');
            $result1=$conn->query($sql1);
            if($result1 === TRUE) {
                $data1=array('status1'=>'true');
                $result2=$conn->query($sql2);
                if($result2 === TRUE)
                {
                    $data2=array('status2'=>'true');
                    $result3 = $conn->query($sql3);
                    if($result3 === TRUE)
                    {
                        $data3 = array('status3' => 'true');
                        return array_merge($data,$data1,$data2,$data3);
                        //$conn->commit();
                    }
                }
                
            }
        } else {
            //$conn->rollback();
            return $data;
        }

    }

    public function addStudents($studentID,$studentName,$degree,$email,$tenure_start,$tenure_end)
    {
        global $conn;
        $data=array('status'=>'false');
        $sql1="insert into students values('$studentID','$studentName','$degree','$email',NULL,'$tenure_start','$tenure_end');";
        $result = $conn->query($sql1);
    
        if ($result === TRUE) {
            $data=array('status'=>'true');
            return $data;
        } else {
            return $data;
        }

        if($data['status'] == 'true')
        {
            $conn->commit();
        }
        else
        {
            $conn->rollback();
        }
        $conn->close();
    }

    public function addGuides($guideID,$guideName,$desination,$department,$contactNo,$guide_email)
    {
        global $conn;
        $data=array('status'=>'false');
        $sql1="insert into guides values('$guideID','$guideName','$desination','$department','$contactNo','$guide_email');";
        $result = $conn->query($sql1);
    
        if ($result === TRUE) {
            $data=array('status'=>'true');
        } 

        if($data['status'] == 'true')
        {
            $conn->commit();
        }
        else
        {
            $conn->rollback();
        }

        return $data;
        $conn->close();
        
    }

    public function viewDocument($studentID,$timestamp)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select document, document_name from documents where document_description like 'proposal' and student_ID like '$studentID' and submission_time like '$timestamp';";
        $result=$conn->query($sql);

        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status1'=>'true');
            $dataval=array('documents'=>$arr);
            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }

        $conn->close();
    }

    public function addNotifications($projectID,$message)
    {
        global $conn;
        $data2=array('status2'=>'false');

        $sql2 = "INSERT INTO notifications(project_ID,message_time,message) VALUES('$projectID',CURRENT_TIME,'$message');";
        $result2 = $conn->query($sql2);

        if ($result2 === TRUE) {
            $data2=array('status2'=>'true');
        } 

        if($data2['status2'] == 'true')
        {
            $conn->commit();
        }
        else
        {
            $conn->rollback();
        }

        return $data2;
        $conn->close();
    }

     public function viewIRBMembers()
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from IRBMembers;";
        $result=$conn->query($sql);

        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status1'=>'true');
            $dataval=array('documents'=>$arr);
            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }

        $conn->close();
    }

    public function setMeetings($IRB_ID,$projectID)
    {
        global $conn;
        $data=array('status'=>'false');
        $sql1="insert into IRB_Meeting(IRB_ID,project_ID,status) values('$IRB_ID','$projectID',0);";
        $result = $conn->query($sql1);
    
        if ($result === TRUE) {
            $data=array('status'=>'true');
        } 

        if($data['status'] == 'true')
        {
            $conn->commit();
        }
        else
        {
            $conn->rollback();
        }

        return $data;
        $conn->close();

    }

    public function viewProjectsForMeetings()
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from projects where approved_by_IRB = 0;";
        $result=$conn->query($sql);
        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status1'=>'true');
            $dataval=array('documents'=>$arr);
            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
        $conn->close();
    }

    // public function finalizeMeeting($projectID)
    // {
    //     global $conn;
    //     $sql="select count(IRB_ID) from IRB_Meeting where status > 0 and project_ID like '$projectID'";
    //     $result=$conn->query($sql);
    //     if ($result->num_rows > 0) {
    //         while($row = $result->fetch_assoc())
    //         {
    //             $val = $row['count(IRB_ID)'];
    //         }
    //     }
    //     if($val > 5) //The meeting is finalized so you can change the limit
    //     {
    //         $data=array('status'=>'false');
    //         $sql1="update dates_of_everything set EC_meeting = CURRENT_DATE where project_ID like '$projectID'";
    //         $result = $conn->query($sql1);

    //         if ($result === TRUE) {
    //             $data=array('status'=>'true');
    //         }

    //         if($data['status'] == 'true')
    //         {
    //             $conn->commit();
    //         }
    //         else
    //         {
    //             $conn->rollback();
    //         }

    //         return $data;
    //         $conn->close();
    //     }
    // }

    public function viewVouchers()
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from documents where document_description like 'voucher' and document_status = 0";
        $result=$conn->query($sql);
        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status1'=>'true');
            $dataval=array('documents'=>$arr);
            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
        $conn->close();
    }
    
    public function viewIndividualVoucher($studentID,$timestamp)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select document from documents where document_description like 'voucher' and student_ID like '$studentID' and submission_time like '$timestamp';";
        $result=$conn->query($sql);
        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status1'=>'true');
            $dataval=array('documents'=>$arr);

            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
        $conn->close();
    }
    
    public function approveVouchers($studentID,$timestamp,$document)
    {
        global $conn;
        $data=array('status'=>'false');
        $sql1="update documents set document_status = 1, document = '$document' where student_ID like '$studentID' and submission_time like '$timestamp' and document_description like 'voucher'";
        $result = $conn->query($sql1);
    
        if ($result === TRUE) {
            $data=array('status'=>'true');
            return $data;
        } else {
            return $data;
        }

        if($data['status'] == 'true')
        {
            $conn->commit();
        }
        else
        {
            $conn->rollback();
        }
        $conn->close();
    }

    public function viewUnapprovedProjects()
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from projects where approved_by_IRB = 1;";
        $result=$conn->query($sql);
        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status1'=>'true');
            $dataval=array('documents'=>$arr);
            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
        $conn->close();
    }

    public function addMinutes($document,$documentname,$projectID,$secretariatID)
    {
        global $conn;
        $data=array('status'=>'false');
        $sql1="insert into documents(document,document_name,document_description,submission_time,project_ID,ID) values('$document','$documentname','minutes',CURRENT_DATE,'$projectID','$secretariatID');";
        $result = $conn->query($sql1);
    
        if ($result === TRUE) {
            $data=array('status'=>'true');
            return $data;
        } else {
            return $data;
        }

        if($data['status'] == 'true')
        {
            $conn->commit();
        }
        else
        {
            $conn->rollback();
        }
        $conn->close();

    }

}
?>