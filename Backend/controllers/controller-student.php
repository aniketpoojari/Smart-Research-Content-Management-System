<?php
$studentID = $_REQUEST['studentID'];

require_once '../models/model-student.php';

$studentObject = new ModelStudent;

/*$document='drive.google.com/link_href?=bad_example';
$documentname='example_document';
$studentID='1';
$guideID = '10001';*/

$action = $_REQUEST['action'];
//$action = 'addProposals';
    switch($action){
        case 'getMaterials':
            $var1 = $studentObject->getMaterials();
            echo json_encode($var1);
            break;
        case 'addProposals':
            $document = $_REQUEST['document'];
            $documentname = $_REQUEST['documentname'];
            $var1 = $studentObject->addProposals($document,$documentname,$studentID);
            echo json_encode($var1);
            break;
        case 'addBudget':
            $document = $_REQUEST['document'];
            $documentname = $_REQUEST['documentname'];
            $var1 = $studentObject->addBudget($document,$documentname,$studentID);
            echo json_encode($var1);
            break;

        case 'viewSubmittedProposals':
            $var1 = $studentObject->viewSubmittedProposals($studentID);
            echo json_encode($var1);
            break;

        case 'viewProjects':
            $var1 = $studentObject->viewProjects($studentID);
            echo json_encode($var1);
            break;

        case 'fetchProjects':
            $projectID = $_REQUEST['projectID'];
            $var1 = $studentObject->fetchProjects($projectID);
            echo json_encode($var1);
            break;

        case 'viewGuides':
            $var1 = $studentObject->viewGuides($studentID);
            echo json_encode($var1);
            break;
        

        case 'addPrincipleGuide':
            $guideID = $_REQUEST['guideID'];
            $var1 = $studentObject->addPrincipleGuide($guideID,$studentID);
            echo json_encode($var1);
            break;

        case 'addOtherGuides':
            $guideID = $_REQUEST['guideID'];
            $var1 = $studentObject->addOtherGuides($guideID,$studentID);
            echo json_encode($var1);
            break;
        
        case 'viewOwnGuides':
            $var1 = $studentObject->viewOwnGuides($studentID);
            echo json_encode($var1);
            break;

        case 'addDocuments':
            $document = $_REQUEST['document'];
            $documentname = $_REQUEST['documentname'];
            $projectID = $_REQUEST['projectID'];
            $description = $_REQUEST['description'];
            $var1 = $studentObject->addDocuments($document,$documentname,$studentID,$description,$projectID);
            echo json_encode($var1);
            break;

        case 'viewDocuments':
            $projectID = $_REQUEST['projectID'];
            $var1 = $studentObject->viewDocuments($projectID);
            echo json_encode($var1);
            break;

        case 'viewQueryLetter':
            $projectID = $_REQUEST['projectID'];
            $var1 = $studentObject->viewDocuments($projectID);
            echo json_encode($var1);
            break;

        case 'viewBudget':
            $var1 = $studentObject->viewBudget($studentID);
            echo json_encode($var1);
            break;

        case 'viewSubmittedProposalwithTime':
            $submission_time = $_REQUEST['submission_time'];
            $var1 = $studentObject->viewSubmittedProposalwithTime($studentID,$submission_time);
            echo json_encode($var1);
            break;

        case 'viewSubmittedBudgetwithTime':
            $submission_time = $_REQUEST['submission_time'];
            $var1 = $studentObject->viewSubmittedBudgetwithTime($studentID,$submission_time);
            echo json_encode($var1);
            break;
        
        case 'viewNotifications':
            $studentID = $_REQUEST['studentID'];
            $var1 = $studentObject->viewNotifications($studentID);
            echo json_encode($var1);
            break;

        case 'viewAllNotifications':
            $studentID = $_REQUEST['studentID'];
            $var1 = $studentObject->viewAllNotifications($studentID);
            echo json_encode($var1);
            break;

        case 'editDocuments':
            $document = $_REQUEST['document'];
            $studentID = $_REQUEST['studentID'];
            $documentname = $_REQUEST['documentname'];
            $timestamp = $_REQUEST['submission_time'];
            $var1 = $studentObject->editDocuments($document,$studentID,$documentname,$timestamp);
            echo json_encode($var1);
            break;

        
    }