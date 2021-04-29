<?php
$studentID = $_REQUEST['studentID'];
/*$studentID = 'ID1';
$projectname="Nehru had Bose killed";
$budget_proposed=1050069;
$derived_from = 'PD6';
$variablePath = 'https://www.google.com/p?=yogi.txt';
$documentDescription = 'progress_report_3';
$projectID = 'PD104';*/

require_once '../models/model-student.php';

$studentObject = new ModelStudent;

$action = $_REQUEST['action'];
//$action = 'viewDocument';
    switch($action){

            case 'addProjects':
                $projectname = $_REQUEST['projectname'];
                $derived_from = $_REQUEST['derived_from'];
                $budget_proposed = $_REQUEST['budget_proposed'];
                if($derived_from == null){
                    $derived_from = 'PD0';
                }
                $var = $studentObject->addProjects($projectname,$derived_from,$studentID,$budget_proposed);
                echo json_encode($var);
                break;

            case 'viewDocument':
                $projectID = $_REQUEST['projectID'];
                $var1 = $studentObject->viewDocuments($studentID,$projectID);
                echo json_encode($var1);
                break;

            case 'viewFinances':
                $var2= $studentObject->viewFinances($studentID);
                echo json_encode($var2); 
                break;

            case 'viewGuides':
                $var3 = $studentObject->viewGuides($studentID);
                echo json_encode($var3);
                break;

            case 'viewSelf':
                $var4 = $studentObject->viewSelf($studentID);
                echo json_encode($var4);
                break;

            case 'viewProjects':
                $var5 = $studentObject->viewProjects($studentID);
                echo json_encode($var5);
                break;

            case 'viewDeadlines':
                $var6 = $studentObject->viewDeadlines($studentID);
                echo json_encode($var6);
                break;

            case 'addDocuments':
                $variablePath = $_REQUEST['variablePath'];
                $documentDescription = $_REQUEST['documentDescription'];
                $projectID = $_REQUEST['projectID'];
                $document_name = $_REQUEST['document_name'];
                $var6 = $studentObject->addDocuments($variablePath,$document_name,$documentDescription,$projectID);
                echo json_encode($var6);
                break;

            case 'fetchProject':
                $projectID = $_REQUEST['projectID'];
                $var1 = $studentObject->fetchProject($studentID,$projectID);
                echo json_encode($var1);
                break;

            case 'viewApprovedProjects':
                $var1 = $studentObject->viewApprovedProjects($studentID);
                echo json_encode($var1);
                break;    
                

    }