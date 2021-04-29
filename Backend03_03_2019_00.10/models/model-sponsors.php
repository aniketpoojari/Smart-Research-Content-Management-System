<?php
require_once "../database/connection.php";

class ModelSponsors
{
    public function addFinances($invoiceNumber,$amount,$projectID,$sponsorName)
    {
        global $conn;
        $data=array('status'=>'false');
        $sql1="insert into finances values('$invoiceNumber','$sponsorName',$amount,'$projectID');";
        $result = $conn->query($sql1);
    
        if ($result === TRUE) {
            $data=array('status'=>'true');
            return $data;
        } else {
            return $data;
        }
    }

    public function viewFinances($sponsorName)
      {
          global $conn;
          $data=array('status'=>'false');

          $sql= "SELECT finances.invoice_number,finances.sponsor_name,finances.amount_donated_by_sponsor,finances.project_ID FROM finances WHERE sponsor_name like '$sponsorName';";
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

    public function viewProjects($sponsorName)
    {
        global $conn;
        $data=array('status'=>'false');

        $sql="select projects.project_ID,projects.project_name, projects.derived_from, projects.date_of_start, projects.date_of_completion, projects.completed, projects.project_price, projects.guide_ID, projects.budget_proposed from projects,finances where projects.project_ID like finances.project_ID and projects.completed <> 1 and finances.sponsor_name like '$sponsorName';";
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