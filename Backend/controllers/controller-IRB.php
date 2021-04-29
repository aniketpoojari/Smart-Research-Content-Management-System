<?php
//$IRBID = $_REQUEST['IRBID'];

require_once '../models/model-IRB.php';
// $projectID = 'PD0';
$IRBObject = new ModelIRB;

require_once '../PHPMailer/mail.php';
global $mail;

$action = $_REQUEST['action'];
// $action = 'disapproveProposals';
    switch($action){
        case 'viewProposals':
            $var=$IRBObject->viewProposals();
            echo json_encode($var);
            break;
        
        case 'viewDocumentsPerProjects':
            //$projectID = $_REQUEST['projectID'];
            $var = $IRBObject->viewDocumentsPerProject($projectID);
            echo json_encode($var);
            break;
    
        case 'approveProposals':
            $projectID = $_REQUEST['projectID'];
            $var = $IRBObject->approveProposals($projectID);
            echo json_encode($var);


            $mail->isHTML(true);
            $mail->Subject = "Your Proposal was approved by IRB";
            $mail->Body = "Your Proposal was approved by IRB with projectID = '$projectID";
            $mail->AltBody = "This is the plain text version of the email content";
            //$mail->send();
            $mail->addAddress('yogenyat@gmail.com');
                $mail->send();

            break;

        case 'disapproveProposals':
            //$projectID = $_REQUEST['projectID'];
            $var = $IRBObject->disapproveProposals($projectID);
            echo json_encode($var);
            
            $sql = "select DISTINCT student_email from students;";
            $result=$conn->query($sql);
            if ($result->num_rows > 0) {
                $arr = [];
                while($row = $result->fetch_assoc())
                {
                    array_push($arr,$row['student_email']);
                }
            } 
            
            
            $mail->isHTML(true);
            $mail->Subject = "Your Proposal was disapproved by IRB";
            $mail->Body = "Your Proposal was disapproved by IRB with projectID = '$projectID";
            $mail->AltBody = "This is the plain text version of the email content";
            foreach($arr as $value)
            {
                //$value = (string)$value;
                //echo $value."<br>";
                $mail->addAddress($value);
                $mail->send();
            }

            break;
        
        case 'dropProposals':
            //$projectID = $_REQUEST['projectID'];
            $var = $IRBObject->dropProposals($projectID);
            echo json_encode($var);

            $sql = "select DISTINCT student_email from students;";
            $result=$conn->query($sql);
            if ($result->num_rows > 0) {
                $arr = [];
                while($row = $result->fetch_assoc())
                {
                    array_push($arr,$row['student_email']);
                }
            } 
            
            
            $mail->isHTML(true);
            $mail->Subject = "Proposal Drop";
            $mail->Body = "Your Proposal was dropped by IRB with projectID = '$projectID";
            $mail->AltBody = "This is the plain text version of the email content";
            foreach($arr as $value)
            {
                //$value = (string)$value;
                //echo $value."<br>";
                $mail->addAddress($value);
                $mail->send();
            }

            break;

    }
?>