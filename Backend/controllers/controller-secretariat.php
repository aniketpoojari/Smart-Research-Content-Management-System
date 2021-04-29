<?php



require_once '../models/model-secretariat.php';
$secretariatObject = new ModelSecretariat;
require_once '../PHPMailer/mail.php';
global $mail;

$action = $_REQUEST['action'];
//$action = 'viewUnapprovedProjects';

switch($action){

    
    case    'viewProposalBeforeDirector':
            $var1 = $secretariatObject->viewProposalBeforeDirector();
            echo json_encode($var1);
            break;        
    case    'viewDocument':
            $studentID = $_REQUEST['studentID'];
            $timestamp = $_REQUEST['submission_time'];
            $var = $secretariatObject->viewDocument($studentID,$timestamp);
            echo json_encode($var);
            break;
    case    'approveDocumentsBeforeDirector':
            $studentID = $_REQUEST['studentID'];
            $var1 = $secretariatObject->approveDocumentsBeforeDirector($studentID);
            echo json_encode($var1);
            break;

    case    'viewUnapprovedProjects':
            $var = $secretariatObject->viewUnapprovedProjects();
            echo json_encode($var);
            break;    

    case    'sendQueryLetters':
            $secretariatID = $_REQUEST['secretariatID'];
            $document=$_REQUEST['document'];
            $documentname=$_REQUEST['documentname'];
            $projectID=$_REQUEST['projectID'];
            $var=$secretariatObject->sendQueryLetters($document,$documentname,$projectID,$secretariatID);
            echo json_encode($var);

            $message = 'Query letter has been generated for your project';
            $var2=$secretariatObject->addNotifications($projectID,$message);
            echo json_encode($var2);

            $sql = "select DISTINCT students.student_email from students,project_student_mapping where project_student_mapping.student_ID = students.student_ID and project_student_mapping.project_ID = '$projectID';";
            $result=$conn->query($sql);

            if ($result->num_rows > 0) {
                $arr = [];
                while($row = $result->fetch_assoc())
                {
                    array_push($arr,$row['student_email']);
                }
            } 
               
            $mail->isHTML(true);
            $mail->Subject = "Query Letters Updation";
            $mail->Body = "$message";
            $mail->AltBody = "This is the plain text version of the email content";
            foreach($arr as $value)
            {
                $mail->addAddress($value);
                $mail->send();
            }

            break;

    case    'viewProposalAfterDirector':
            $var1 = $secretariatObject->viewProposalAfterDirector();
            echo json_encode($var1);
            break;            
    case    'addProjects':
            $studentID=$_REQUEST['studentID'];
            $projectID=$_REQUEST['projectID'];
            $projectname=$_REQUEST['projectname'];
            $guideID=$_REQUEST['guideID'];
            $endDate = $_REQUEST['endDate'];
            $var = $secretariatObject->addProjects($studentID,$projectID,$projectname,$guideID,$endDate);
            echo json_encode($var);

            $message = 'ProjectID has been generated for you proposal.';
            $var2=$secretariatObject->addNotifications($projectID,$message);
            echo json_encode($var2);

            $sql = "select DISTINCT students.student_email from students,project_student_mapping where project_student_mapping.student_ID = students.student_ID and project_student_mapping.project_ID = '$projectID';  ";
            $result=$conn->query($sql);

            if ($result->num_rows > 0) {
                $arr = [];
                while($row = $result->fetch_assoc())
                {
                    array_push($arr,$row['student_email']);
                }
            } 
        
            $mail->isHTML(true);
            $mail->Subject = "ProjectID generated.";
            $mail->Body = "$message";
            $mail->AltBody = "This is the plain text version of the email content";
            foreach($arr as $value)
            {
                echo $value;
                $mail->addAddress($value);
                $mail->send();
            }

            break;




    case    'addStudents':
            $studentID = $_REQUEST['studentID'];
            $studentName = $_REQUEST['studentName'];
            $degree = $_REQUEST['degree'];
            $email = $_REQUEST['email'];
            $st_date = $_REQUEST['st_date'];
            $end_date = $_REQUEST['end_date'];
            $var = $secretariatObject->addStudents($studentID,$studentName,$degree,$email,$st_date,$end_date);
            echo json_encode($var);

            $message = 'You have been regestered in the system.';
        
            $mail->isHTML(true);
            $mail->Subject = "PD Hinduja welcomes you";
            $mail->Body = "$message";
            $mail->AltBody = "This is the plain text version of the email content";
            $mail->addAddress($email);
            $mail->send();
            break;
    case    'addGuides':
            $guideID = $_REQUEST['guideID'];
            $guideName= $_REQUEST['guideName'];
            $designation = $_REQUEST['designation'];
            $department = $_REQUEST['department'];
            $contactNo = $_REQUEST['contactNo'];
            $guide_email = $_REQUEST['guide_email'];
            $var = $secretariatObject->addGuides($guideID,$guideName,$designation,$department,$contactNo,$guide_email);
            echo json_encode($var);

            $message = 'You have been regestered in the system.';
        
            $mail->isHTML(true);
            $mail->Subject = "PD Hinduja welcomes you";
            $mail->Body = "$message";
            $mail->AltBody = "This is the plain text version of the email content";
            $mail->addAddress($guide_email);
            $mail->send();

            break;


        // case 'finalizeMeeting':
        //     $projectID = $_REQUEST['projectID'];
        //     $var = $secretariatObject->finalizeMeeting($projectID);
        //     echo json_encode($var);
        //     break;




        case 'viewVouchers':
            $var = $secretariatObject->viewVouchers();
            echo json_encode($var);
            break;
        case 'viewIndividualVoucher':
            $studentID = $_REQUEST['studentID'];
            $timestamp = $_REQUEST['submission_time'];
            $var = $secretariatObject->viewIndividualVoucher($studentID,$timestamp);
            echo json_encode($var);
            break;
        case 'approveVouchers':
            $studentID = $_REQUEST['studentID'];
            $timestamp = $_REQUEST['timestamp'];
            $document = $_REQUEST['document'];
            $var = $secretariatObject->approveVouchers($studentID,$timestamp,$document);
            echo json_encode($var);
            break;
        

        case 'viewProjectsForMeetings':
            $var = $secretariatObject->viewProjectsForMeetings();
            echo json_encode($var);
            break;
        case 'viewIRBMembers':
            $var = $secretariatObject->viewIRBMembers();
            echo json_encode($var);
            break;
        case 'setMeetings':
            $projectID = $_REQUEST['projectID'];
            $arr_length = $_REQUEST['arr_length'];
            $irbids = $_REQUEST['irbids'];
            $irbmails = $_REQUEST['irbmails'];
            $irbidsarr = explode(",",$irbids);
            $irbmailsarr = explode(",",$irbmails);
            $agenda = $_REQUEST['agenda'];

            for ($x =0 ; $x < $arr_length; $x++) {
                $var = $secretariatObject->setMeetings($irbidsarr[$x],$projectID);
                echo json_encode($var);
            }

            $message = "$agenda.<br> .Meeting has been set....please confirm your status by logging on to the website";
            $mail->isHTML(true);
            $mail->Subject = "ProjectID generated.";
            $mail->Body = "$message";
            $mail->AltBody = "This is the plain text version of the email content";
            for ($x =0 ; $x < $arr_length; $x++)
            {
                $mail->addAddress($irbmailsarr[$x]);
                $mail->send();
            }
            // echo json_encode('Mail sent Successfully');
            break;   
            

        


        case 'addMinutes':
            $document = $_REQUEST['document'];
            $documentname=$_REQUEST['documentname'];
            $projectID=$_REQUEST['projectID'];
            $secretariatID=$_REQUEST['secretariatID']; 
            $var = $secretariatObject->addMinutes($document,$documentname,$projectID,$secretariatID);
            echo json_encode($var);
            break;
    }
?>