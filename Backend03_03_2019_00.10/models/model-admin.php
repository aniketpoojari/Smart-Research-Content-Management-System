<?php
#function to add projects to the database which the admin will use


class ModelAdmin
{
    public function addProjects($studentID,$projectname,$derived_from,$budget_proposed,$studentName,$projectID)
        {
            global $conn;
            $data1=array('status1'=>'false');
            $data2=array('status2'=>'false');
            $data3=array('status2'=>'false');

            $sql1="insert into projects values('$projectID','$projectname','$derived_from',0,CURRENT_DATE,NULL,0,NULL,'ID1',$budget_proposed);";
            $result1 = $conn->query($sql1);

            if ($result1 === TRUE) {

                $sql2="insert into deadlines values('$projectID',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);";
                $result2 = $conn->query($sql2);

                if ($result2 === TRUE) {
                    $data2=array('status2'=>'true');
                } else {
                    $data2=array('status2'=>'false');
                }  

                $sql3="select project_ID from student where student_ID like '$studentID';";
                $result= $conn->query($sql3);
                if ($result->num_rows > 0) {
                    $arr = [];
                    while($row = $result->fetch_assoc()) 
                    {
                        array_push($arr,$row);
                    }
                }
                    if($arr[0]["project_ID"] == null)
                    {
                        $sql4="update student set project_ID='$projectID' where student_ID like '$studentID';";
                        $result=$conn->query($sql4);
                        if ($result === TRUE) {
                            $data3=array('status3'=>'true');
                        } else {
                            $data3=array('status3'=>'false');
                        }
                        
                    }
                    else
                    {
                        $sql5="insert into student values('$studentID','$studentName','$projectID'); ";
                        $result=$conn->query($sql5);
                        if ($result === TRUE) {
                            $data3=array('status3'=>'true');
                        } else {
                            $data3=array('status3'=>'false');
                        }
                    }
                return array_merge($data2,$data3);
            }
            else{
                return $data1;
            }

        }
}