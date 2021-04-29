<?php
//$RDID = $_REQUEST['RDID'];

$studentID = 'ID3';
$derivedFrom = 'PD6';
$projectName = 'Nehru had Bose killed';
$description = 'proposal';
$projectID = 'PD101';

require_once '../models/model-rd.php';
$rdObject = new ModelRD;

//$action = $_REQUEST['action'];
$action = 'viewPendingProjects';
    switch($action){

        case 'viewDocuments':
            $var = $rdObject->viewDocuments();
            echo json_encode($var);
            break;

        case 'viewApprovedProjects':
            $var = $rdObject->viewApprovedProjects();
            echo json_encode($var);
            break;

        case 'viewDispprovedProjects':
            $var = $rdObject->viewDispprovedProjects();
            echo json_encode($var);
            break;

        case 'viewPendingProjects':
            $var = $rdObject->viewPendingProjects();
            echo json_encode($var);
            break;

        case 'viewFinances':
            $var = $rdObject->viewFinances();
            echo json_encode($var);
            break;

        case 'approveProjects':
            /*$studentID = $_REQUEST['studentID'];
            $derivedFrom = $_REQUEST['derivedFrom'];
            $projectName = $_REQUEST['projectName'];
           */
            $var = $rdObject->approveProjects($studentID,$derivedFrom,$projectName);
            echo json_encode($var);
            break;

        case 'approveProposal':
        /*
            $description = $_REQUEST['description'];
            $projectID = $_REQUEST['projectID'];
           */
            $var = $rdObject->approveProposal($projectID,$description);
            echo json_encode($var);
            break;

        case 'disApproveProjects':
            /*$studentID = $_REQUEST['studentID'];
            $derivedFrom = $_REQUEST['derivedFrom'];
            $projectName = $_REQUEST['projectName'];
           */
            $var = $rdObject->disApproveProjects($studentID,$derivedFrom,$projectName);
            echo json_encode($var);
            break;

        case 'disapproveDocuments':
            //$projectID = $_REQUEST['projectID'];
            //$description = $_REQUEST['$description'];
            $var = $rdObject->disapproveDocuments($projectID,$description);
            echo json_encode($var);
            break;
    }

