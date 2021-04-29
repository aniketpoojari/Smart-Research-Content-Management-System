<?php
$guideID = $_REQUEST['guideID'];
/*
$guideID = '10001';
$projectID = 'PD1';
*/
require_once '../models/model-guide.php';

$guideObject = new ModelGuide;

$action = $_REQUEST['action'];
//$action = 'viewPrincipleDocumentsPerProject';
    switch($action){
        case 'viewProposals':
            $var1 = $guideObject->viewProposals($guideID);
            echo json_encode($var1);
            break;

        case 'approveProposals':
            $timestamp = $_REQUEST['submission_time'];
            $studentID = $_REQUEST['studentID'];
            $var1 = $guideObject->approveProposals($guideID,$timestamp,$studentID);
            echo json_encode($var1);
            break;
        
        case 'viewPrincipleProjects':
            $var1 = $guideObject->viewPrincipleProjects($guideID);
            echo json_encode($var1);
            break;
        
        case 'viewParticipatingProjects':
            $var1 = $guideObject->viewParticipatingProjects($guideID);
            echo json_encode($var1);
            break;

        case 'viewPrincipleDocumentsPerProject':
            $projectID = $_REQUEST['project_ID'];
            $var1 = $guideObject->viewPrincipleDocumentsPerProject($projectID,$guideID);
            echo json_encode($var1);
            break;

        case 'approveDocuments':
            $projectID = $_REQUEST['projectID'];
            $description = $_REQUEST['description'];
            $timestamp = $_REQUEST['submission_time'];
            $var1 = $guideObject->approveDocuments($projectID,$description,$timestamp);
            echo json_encode($var1);
            break;

        case 'viewApprovedProposals':
            $timestamp = $_REQUEST['submission_time'];
            $var1 = $guideObject->viewApprovedProposals($guideID,$timestamp);
            echo json_encode($var1);
            break;
        
        case 'editDocuments':
            $document = $_REQUEST['document'];
            $studentID = $_REQUEST['studentID'];
            $documentname = $_REQUEST['documentname'];
            $timestamp = $_REQUEST['submission_time'];
            $var1 = $guideObject->editDocuments($document,$studentID,$documentname,$timestamp);
            echo json_encode($var1);
            break;

        case 'viewProposalWithTime':
            $timestamp = $_REQUEST['submission_time'];
            $studentID = $_REQUEST['studentID'];
            $var1 = $guideObject->viewProposalWithTime($studentID,$timestamp);
            echo json_encode($var1);
            break;

        case 'viewProjectDocuments':
            $projectID = $_REQUEST['projectID'];
            $var1 = $guideObject->viewProjectDocuments($projectID);
            echo json_encode($var1);
            break;
        
}