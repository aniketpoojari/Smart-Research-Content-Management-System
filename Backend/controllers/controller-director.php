<?php
//$directorID = $_REQUEST['DirectorID'];

require_once '../models/model-director.php';

// $studentID='2';
// /*$studentName='Jane Doe';
// $degree='MD';
// $email='jdoe93@gmail.com';
// $guideID='10000';
// $guideName='Madhav Mukund';
// $guide_email = 'mmukund@gmail.com';
// $projectID='PD2016';
// $projectname='Brain research';
// $guideID = '10000';*/
// $guideID = '10001';
// $guideName= 'Prakash Suraj';
// $guide_email = 'psuraj78@gmail.com';


$directorObject = new ModelDirector;

$action = $_REQUEST['action'];
//$action = 'viewIndividualBudget';
    switch($action){
        
        case 'viewProposals':
            $var = $directorObject->viewProposals();
            echo json_encode($var);
            break;

        case 'viewBudgets':
            $var1 = $directorObject->viewBudgets();
            echo json_encode($var1);
            break;
        
        case 'approveProjects':
            $studentID = $_REQUEST['studentID'];
            $timestamp = $_REQUEST['timestamp'];
            $var1 = $directorObject->approveProjects($studentID,$timestamp);
            echo json_encode($var1);
            break;

        case 'disapproveProjects':
            $studentID = $_REQUEST['studentID'];
            $timestamp = $_REQUEST['timestamp'];
            $var1 = $directorObject->disapproveProject($studentID,$timestamp);
            echo json_encode($var1);
            break;

        case 'viewIndividualProposal':
            $studentID = $_REQUEST['studentID'];
            $timestamp = $_REQUEST['submission_time'];
            $var1 = $directorObject->viewIndividualProposal($studentID,$timestamp);
            echo json_encode($var1);
            break;
        
        case 'viewIndividualBudget':
            $studentID = $_REQUEST['studentID'];
            $timestamp = $_REQUEST['submission_time'];
            $var1 = $directorObject->viewIndividualBudget($studentID,$timestamp);
            echo json_encode($var1);
            break;

        case 'viewProjects':
            $var1 = $directorObject->viewProjects();
            echo json_encode($var1);
            break;

        case 'viewMinutes':
            $var1 = $directorObject->viewMinutes();
            echo json_encode($var1);
            break;
        
        case 'viewProposalsAfterMeeting':
            $var = $directorObject->viewProposalsAfterMeeting();
            echo json_encode($var);
            break;

        case 'approveProposalsAfterMeeting':
            $projectID = $_REQUEST['projectID'];
            $var1 = $directorObject->approveProposalsAfterMeeting($projectID);
            echo json_encode($var1);
            break;

        case 'disapproveProposalsAfterMeeting':
            $projectID = $_REQUEST['projectID'];
            $var1 = $directorObject->disapproveProposalsAfterMeeting($projectID);
            echo json_encode($var1);
            break;
        
        case 'dropProposalAfterMeeting':
            $projectID = $_REQUEST['projectID'];
            $var1 = $directorObject->dropProposalAfterMeeting($projectID);
            echo json_encode($var1);
            break;
        
        case 'ApproveFinalResearch':
            $projectID = $_REQUEST['projectID'];
            $var1 = $directorObject->approveFinalResearch($projectID);
            echo json_encode($var1);
            break;

        case 'viewVouchers':
            $var1 = $directorObject->viewVouchers();
            echo json_encode($var1);
            break;
        
        case 'viewIndividualVoucher':
            $studentID = $_REQUEST['studentID'];
            $timestamp = $_REQUEST['submission_time'];
            $var1 = $directorObject->viewIndividualVoucher($studentID,$timestamp);
            echo json_encode($var1);
            break;
        
        case 'approveIndividualVoucher':
            $studentID = $_REQUEST['studentID'];
            $timestamp = $_REQUEST['submission_time'];
            $amount = $_REQUEST['amount'];
            $projectID = $_REQUEST['projectID'];
            $var1 = $directorObject->approveIndividualVoucher($studentID,$timestamp,$amount,$projectID);
            echo json_encode($var1);
            break;
                
            

    }