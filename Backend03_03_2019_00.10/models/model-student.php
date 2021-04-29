<?php
require_once '../database/connection.php';

//$variable_count=25;

class ModelStudent 
{
    public $projectname;
    public $derived_from;
    public $budget_proposed;
    
      
    #Function to insert into Projects table
    public function addProjects($projectname,$derived_from,$studentID,$budget_proposed)
    {
        global $conn;
        $data=array('status1'=>'false');
        $sql = "insert into newprojects values('$studentID','$projectname','$derived_from','$budget_proposed',0);";
        $result = $conn->query($sql);
        if ($result === TRUE) {
            $data=array('status'=>'true');
            return $data;
        } else {
            return $data;
        }
    }

    #Function to select from documents
    public function viewDocuments($studentID,$projectID)
    {
        global $conn;
        $data=array('status'=>'false');

        $sql="select documents.Document_ID,documents.document_name, Documents.description, Documents.Time_of_submission, Documents.project_ID from documents,student where student.project_ID like documents.project_ID and student.student_ID like '$studentID' and documents.project_ID like '$projectID';";
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

      #Function to select from finances
      public function viewFinances($studentID)
      {
          global $conn;
          $data=array('status'=>'false');

          $sql= "SELECT finances.invoice_number,finances.sponsor_name,finances.amount_donated_by_sponsor,finances.project_ID FROM finances,student WHERE finances.project_ID = student.project_ID and student.student_ID like '$studentID';" ;
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
    
    #Function to view Guides per students
    public function viewGuides($studentID)
    {
        global $conn;
        $data=array('status'=>'false');

        $sql2="select DISTINCT guides.guide_ID,guides.guide_name from guides,projects,student where guides.guide_ID = projects.guide_ID and projects.project_ID = student.project_ID and student.student_ID = '$studentID';";
        $result = $conn->query($sql2);
        
        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $data=array('status'=>'true');
            $dataval=array('guides'=>$arr);
            #Check if Tanmay wants to merge dataval or arr directly
            return array_merge($data,$dataval);
        } else{
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
    }

    #Function to view information about the student itself
    public function viewSelf($studentID)
    {
        global $conn;
        $data=array('status'=>'false');

        $sql2="select * from student where student.student_ID = '$studentID';";
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
    
    #Function to view ongoing projects
    public function viewProjects($studentID)
    {
        global $conn;
        $data=array('status'=>'false');

        $sql2="select * from newprojects where student_ID like '$studentID';";
        $result = $conn->query($sql2);
        
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
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
    }
    
    #Function to view deadlines of student
    public function viewDeadlines($studentID)
    {
        global $conn;
        $data=array('status'=>'false');

        $sql2="select deadlines.project_ID, deadlines.proposal, deadlines.progress_report_1, deadlines.progress_report_2, deadlines.progress_report_3, deadlines.progress_report_4, deadlines.progress_report_5, deadlines.progress_report_6, deadlines.progress_report_7,deadlines.progress_report_8, deadlines.progress_report_9,deadlines.progress_report_10, deadlines.progress_report_11, deadlines.progress_report_12, deadlines.final_submission_date from deadlines,student where student.project_ID like deadlines.project_ID and student.student_ID = '$studentID';";
        $result = $conn->query($sql2);
        
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

    #Function to upload files
    function addDocuments($variablePath,$document_name,$documentDescription,$projectID)
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

    #function
    function fetchProject($studentID,$projectID)
    {
        global $conn;
        $data = array('status'=>'false');

        $sql = "select DISTINCT projects.project_ID, projects.project_name, projects.derived_from, projects.date_of_start, projects.date_of_completion, projects.completed, projects.project_price, projects.guide_ID, projects.budget_proposed from projects,student where projects.project_ID like '$projectID' and student.student_ID like '$studentID'";
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
    
    /*
    #Function to aded documents
    public function getDeadline($studentID,$projectID)
    {
        global $conn;
        $sql = "select * from deadlines, where project_ID like '$projectID' and student_ID like '$studentID'";
        $result = $conn->query($sql);

        $count = 0;
        if ($result->num_rows > 0) {
            $arr = [];
            while($row = $result->fetch_assoc())
            {
                array_push($arr,$row);
            }
            $arr = json_encode($arr);
            echo $arr;
        } else {
            $print = "Error: " . $sql . "<br>" . $conn->error;
            echo $print;
        }
    }
    */
    
    public function viewApprovedProjects($studentID)
    {
        global $conn;
        $data=array('status'=>'false');

        $sql2="select projects.project_ID,projects.project_name,projects.derived_from,projects.date_of_start,projects.date_of_completion,projects.completed,projects.project_price,projects.guide_ID,projects.budget_proposed from projects, student where projects.project_ID like student.project_ID and student.student_ID like '$studentID';";
        $result = $conn->query($sql2);
        
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
            $dataval = array('result'=>'No Entries Found');
            return array_merge($data,$dataval);
        }
    }
}
