<?php

require_once '../database/connection.php';

class ModelDirector
{ 

    public function viewProposals() //All which are approved by the guide and sent by secretary
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from documents where document_description like 'proposal' and document_status = 2;";
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

    public function viewBudgets() //Budget of all the files which are in its initial stage
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from documents where document_description like 'budget' and document_status = 0;";
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
    
    #this is the function where we have to deal with the budget form
    
    public function approveProjects($studentID,$timestamp) //sends the file to the secretary  (proposal is approved)
    {
        global $conn;
        $data=array('status'=>'false');
        //$data1=array('status1'=>'false');
        $sql="update documents set document_status = 3 where student_ID like '$studentID' and document_description like 'proposal' and submission_time like '$timestamp';";
        $result=$conn->query($sql);
        if($result === TRUE)
        {
            $data=array('status'=>'true');
        }
        else{
        }
        return $data;

        /*
        INSERT CODE FOR MAILING
        */
    }

    public function disapproveProject($studentID,$timestamp) 
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="update documents set document_status = 0 where student_ID like '$studentID' and document_description like 'proposal' and submission_time like '$timestamp';";
        $result=$conn->query($sql);
        if($result === TRUE)
        {
            $data=array('status1'=>'true');
        }
        else{
        }
        return $data;

        /*
        NOW SEND THE MAIL TO GUIDES AND STUDENT 
        */
    }

    public function viewIndividualProposal($studentID,$timestamp)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select document from documents where student_ID like '$studentID' and document_description like 'proposal' and submission_time like '$timestamp';";
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
    public function viewIndividualBudget($studentID,$timestamp)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select document from documents where student_ID like '$studentID' and document_description like 'budget' and submission_time like '$timestamp';";
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


    public function viewProposalsAfterMeeting() //All which are approved by the guide and sent by secretary
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from documents where document_description like 'proposal' and document_status = 4;";
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

    public function approveProposalsAfterMeeting($projectID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $data1=array('status'=>'false');
	    $data2=array('status2'=>'false');
	    $data3 = array('status3'=>'false');
        $sql="update documents set document_status = 5 where project_ID like '$projectID' and document_description like 'proposal';";
        $sql1="update dates_of_everything set approval = CURRENT_DATE where project_ID like '$projectID';";
        $sql2 = "update projects set approved_by_IRB = 2 where project_ID like '$projectID'";
        $sql3 = "update documents set document_status = 1 where project_ID like '$projectID' and document_description like 'budget';";
        $result=$conn->query($sql);
        if($result === TRUE)
        {
            $data=array('status1'=>'true');
            $result1=$conn->query($sql1);
            if($result1===TRUE)
            {
                $data1=array('status'=>'true');
                $result2 = $conn->query($sql2);
		        if($result2 === TRUE)
		        {
			        $data2 = array('status'=>'true');
			        $result3 = $conn->query($sql3);
			        if($result3 === TRUE)
			        {
				        $data3 = array('status'=>'true');
				        return array_merge($data,$data1,$data2,$data3);
				        $conn->commit();
			        }
		        }
            }
        }
        else{
		$conn->rollback();
		return $data;
        }



        #now send the mail over here and make sure the Document is not a form anymore
    }


    public function disapproveProposalsAfterMeeting($projectID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $data1 = array('status2'=>'false');
        
        $sql="update documents set document_status = 0 where project_ID like '$projectID' and document_description like 'proposal';";
        $sql1="update projects set approved_by_IRB = 1 where project_ID like '$projectID';";
        
        $result=$conn->query($sql);
        if($result === TRUE)
        {
            $data=array('status1'=>'true');
            $result1 = $conn->query($sql1);
            if($result1 === TRUE)
            {
                $data1 = array('status'=>'true');
                return array_merge($data,$data1);
                $conn->commit();
            }

        }
        else{
            return $data;
            $conn->rollback();
        }
        



        #now we write the function for mailing student and guide and sending the query letters
    }

    public function dropProposalAfterMeeting($projectID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $data1=array('status'=>'false');
        $sql="update documents set document_status = -1 where project_ID like '$projectID';"; //All the documents have to be status -1 meaning not visible to anyone
        $sql1="update projects set completed = -1 where project_ID like '$projectID';";
        $result=$conn->query($sql);
        if($result === TRUE)
        {
            $data=array('status1'=>'true');
            $result1=$result=$conn->query($sql1);
            if($result1 === TRUE)
            {
                $data1 = array('status'=>'false');
                $conn->commit();
                return array_merge($data,$data1);
            }
        }
        else{
        }
        return $data;
    }

    public function approveFinalResearch($projectID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="update projects set completed = 1 where project_ID like '$projectID'";
        $result=$conn->query($sql);
        if($result === TRUE)
        {
            $data=array('status1'=>'true');
        }
        else{
        }
        return $data;
    }

    public function viewProjects()
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from projects where completed =0 or completed = 1 order by completed";
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

    public function viewVouchers()
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from documents where document_description like 'voucher' and document_status = 1;";
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

    public function viewIndividualVoucher($studentID,$timestamp)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select document from documents where student_ID like '$studentID' and submission_time like '$timestamp' and document_description like 'voucher';";
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

    public function approveIndividualVoucher($studentID,$timestamp,$amount,$projectID)
    {
        global $conn;
        $data=array('status1'=>'false');
        $data1 = array('status2'=>'false');
        $sql="update documents set document_status = 2 where document_description like 'voucher' and student_ID like '$studentID' and submission_time like '$timestamp'";
        $sql1 = "update projects set budget_used = budget_used + $amount where project_ID like '$projectID';";
        $result=$conn->query($sql);

        if($result === TRUE)
        {
            $data = array('status1'=>'true');
            $result1 = $conn->query($sql1);
            if($result1 === TRUE)
            {
                $data1 = array('status2'=>'true');
                return array_merge($data,$data1);
            }
        }
        else{
            return $data;
        }
    }

    public function viewMinutes()
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql="select * from projects where completed = 0 and approved_by_IRB = 0 or approved-by_IRB = 1";
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