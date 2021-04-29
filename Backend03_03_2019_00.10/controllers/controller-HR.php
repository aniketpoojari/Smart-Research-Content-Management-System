<?php
$HRName = $_REQUEST['HRID'];
/*$studentID = 'ID6969';
$studentName = 'Hanoz D.';*/

require_once '../models/model-HR.php';

$HRObject = new ModelHR;

$action = $_REQUEST['action'];
//$action = 'addStudents';
    switch($action){

        case 'addStudents':
            $studentID = $_REQUEST['studentID'];
            $studentName = $_REQUEST['studentName'];
            $var = $HRObject->addStudents($studentID,$studentName);
            echo json_encode($var);
            break;
        
        case 'viewProjects':
            $var = $HRObject->viewProjects();
            echo json_encode($var);
            break;



    }