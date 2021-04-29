<?php
require_once '../database/connection.php';

class ModelGuide
{
    #Function to select from documents
    public function viewDocuments($guideID,$projectID)
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select documents.Document_ID,documents.document_name, Documents.description, documents.Time_of_submission, documents.project_ID from documents,projects,guides where guides.guide_ID like projects.guide_ID and documents.project_ID like projects.project_ID and guides.guide_ID like '$guideID' and projects.project_ID like '$projectID' and documents.document_status = 0;";

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

    #Function to upload files
    public function addDocuments($variablePath,$document_name,$documentDescription,$projectID)
    {
        global $conn;
        $data=array('status'=>'false');
    
        $sql = "insert into documents values('$variablePath','$document_name','$documentDescription',CURRENT_DATE,'$projectID',0);";
        $result = $conn->query($sql);
    
        if ($result === TRUE) {
            $data=array('status'=>'true');
            return $data;
        } else {
            return $data;
        }
    }

    #Function to view projects
    public function viewProjects($guideID)
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select DISTINCT projects.project_ID, projects.project_name, projects.derived_from, projects.date_of_start, projects.date_of_completion, projects.completed, projects.project_price, projects.guide_ID, projects.budget_proposed from projects where projects.guide_ID like '$guideID';";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status'=>'true');
            $dataval=array('deadlines'=>$arr);
        }
        else {
            $dataval = array('deadlines'=>'No Entries Found');
        }
            return array_merge($data,$dataval);
    }
    

    #Update projects send ACCORDING TO TABLE
    public function approveDocuments($projectID,$description)
    {
        global $conn;
        $data=array('status'=>'false');
        $data1=array('status1'=>'false');
        if($description != "proposal")
        {
           $sql="update deadlines set $description = CURRENT_DATE where project_ID = '$projectID';";
           $sql1="update documents set document_status = 1 where description like '$description' and project_ID like '$projectID';";
           $result = $conn->query($sql);
           if ($result === TRUE) {
                $data=array('status'=>'true');
            } else { 
                $data=array('status'=>'false');
            }
            //return $data;
            $result1 = $conn->query($sql1);
           if ($result1 === TRUE) {
                $data1=array('status1'=>'true');
            } else { 
                $data1=array('status1'=>'false');
            }

            $case = "$description got approved";
            $sql_notif = "insert into notifications values('$projectID',CURRENT_TIMESTAMP,'$case');";
            //insert into notifications values('PD101',CURRENT_DATE,'progress_report_4')
            $result_notif = $conn->query($sql_notif);
            if ($result_notif === TRUE) {
                $data_notif=array('status1'=>'true');
            } else { 
                $data_notif=array('status1'=>'false');
            }

            $sql_get = "select DISTINCT student.email from student where student.project_ID = '$projectID';";
            $result_get = $conn->query($sql_get);

            if ($result_get->num_rows > 0) {
                $arr = [];
                while($row = $result_get->fetch_assoc())
                {
                    array_push($arr,$row);
                }
            }
            $size = array('size'=>sizeof($arr));
            $case=array('case'=>$case);

            return array_merge($data,$data1,$size,$arr,$case);
        }
    }
    

    #update documents
    public function disapproveDocuments($projectID,$description)
    {
        global $conn;
        $data=array('status'=>'false');
        $data1=array('status1'=>'false');
        if($description != "proposal")
        {
           //$sql="update deadlines set $description = '0' where project_ID = '$projectID';";
           $sql7 = "update documents set document_status = -1 where description = '$description' and project_ID like '$projectID';";
           $result = $conn->query($sql7);
           if ($result === TRUE) {
            $data=array('status'=>'true');
            } else { 
                $data=array('status'=>'false');
            }

            $case = "$description got disapproved";
            $sql_notif = "insert into notifications values('$projectID',CURRENT_TIMESTAMP,'$case');";
            //insert into notifications values('PD101',CURRENT_DATE,'progress_report_4')
            $result_notif = $conn->query($sql_notif);
            if ($result_notif === TRUE) {
                $data_notif=array('status1'=>'true');
            } else { 
                $data_notif=array('status1'=>'false');
            }

            $sql_get = "select DISTINCT student.email from student where student.project_ID = '$projectID';";
            $result_get = $conn->query($sql_get);

            if ($result_get->num_rows > 0) {
                $arr = [];
                while($row = $result_get->fetch_assoc())
                {
                    array_push($arr,$row);
                }
            }
            $size = array('size'=>sizeof($arr));
            $case=array('case'=>$case);

            return array_merge($data,$size,$case,$size,$arr);
            
        }
    }
    
      #Function to select from finances
      public function viewFinances($guideID)
      {
          global $conn;
          $data=array('status'=>'false');

          $sql= "SELECT finances.invoice_number,finances.sponsor_name,finances.amount_donated_by_sponsor,finances.project_ID FROM finances,projects WHERE finances.project_ID = projects.project_ID and projects.guide_ID like '$guideID';" ;
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

      #Function to select from guides
      public function viewSelf($guideID)
      {
          global $conn;
          $data=array('status'=>'false');
  
          $sql2="select * from guides where guides.guide_ID = '$guideID';";
          $result = $conn->query($sql2);
          
          if ($result->num_rows > 0) {
              $arr = [];
              while($row = $result->fetch_assoc())
              {
                  array_push($arr,$row);
              }
              $data=array('status'=>'true');
              $dataval=array('selfinfo'=>$arr);
              #Check if Tanmay wants to merge dataval or arr directly
              return array_merge($data,$dataval);
          } else{
              $dataval = array('result'=>'No Entries Found');
              return array_merge($data,$dataval);
          }
      }

    #Function to insert into finances
    function addFinances($invoiceNumber,$amount,$projectID,$guideID)
    {
        global $conn;
        $data=array('status'=>'false');

        $sql2="select distinct guide_name from guides where guides.guide_ID = '$guideID';";
        $result = $conn->query($sql2);
        
        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                $resultName=$row["guide_name"];
            }
           //return $resultName;
        }
        $sql1="insert into finances values('$invoiceNumber','$resultName','$amount','$projectID');";
        $result = $conn->query($sql1);
    
        if ($result === TRUE) {
            $data=array('status'=>'true');
            return $data;
        } else {
            return $data;
        }
    }
    
    public function viewFinanced($guideID)
    {
        global $conn;
        $data=array('status'=>'false');
        $sql2="select distinct guide_name from guides where guides.guide_ID = '$guideID';";
        $result = $conn->query($sql2);

        if ($result->num_rows > 0) {
        $arr = [];
        while($row = $result->fetch_assoc())
        {
            $resultName=$row["guide_name"];
        }
        $sql3="SELECT finances.invoice_number,finances.sponsor_name,finances.amount_donated_by_sponsor,finances.project_ID FROM finances,projects WHERE finances.project_ID = projects.project_ID and finances.sponsor_name like '$resultName';";
        $result = $conn->query($sql3);

        if ($result->num_rows > 0) {
        $arr = [];
        while($row = $result->fetch_assoc())
        {
            array_push($arr,$row);
        }
        $data=array('status'=>'true');
        $dataval=array('selfFinanced'=>$arr);
        #Check if Tanmay wants to merge dataval or arr directly
        return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
        }
    }

    public function viewApprovedDocuments($guideID,$projectID)
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select documents.Document_ID,documents.document_name, Documents.description, documents.Time_of_submission, documents.project_ID,documents.document_status from documents,projects,guides where guides.guide_ID like projects.guide_ID and documents.project_ID like projects.project_ID and guides.guide_ID like '$guideID' and projects.project_ID like '$projectID' and documents.document_status <>0;";
        

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

    public function viewNotifications($guideID)
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select notifications.project_ID, notifications.date, notifications.message from notifications,projects where projects.project_ID = notifications.project_ID and projects.guide_ID = '$guideID';";
        

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
}