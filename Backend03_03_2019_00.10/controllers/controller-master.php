<?php
$masterID = $_REQUEST['masterID'];

require_once '../models/model-master.php';

$masterObject = new ModelMasters;

$action = $_REQUEST['action'];
//$action = 'viewAllGuides';
    switch($action){

        case 'viewAllFinances':
            $var = $masterObject->viewAllFinances();
            echo json_encode($var);
            break;

        case 'viewAllProjects':
            $var = $masterObject->viewAllProjects();
            echo json_encode($var);
            break;

        case 'viewAllDocuments':
            $var = $masterObject->viewAllDocuments();
            echo json_encode($var);
            break;
        
        case 'viewAllGuides':
            $var = $masterObject->viewAllGuides();
            echo json_encode($var);
            break;
            
        case 'viewAllStudents':
            $var = $masterObject->viewAllStudents();
            echo json_encode($var);
            break;

        case 'viewAllDeadlines':
            $var = $masterObject->viewAllDeadlines();
            echo json_encode($var);
            break;

    }

