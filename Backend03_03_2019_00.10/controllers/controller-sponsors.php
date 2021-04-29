<?php
$sponsorName = $_REQUEST['sponsor_name'];
/*$sponsorName = 'Hanoz';
$invoiceNumber='IDB694569';
$amount=10;
$projectID='PD5';*/

require_once '../models/model-sponsors.php';

$sponsorObject = new ModelSponsors;

$action = $_REQUEST['action'];
//$action = 'viewAllProjects';
    switch($action){

        case 'viewFinances':
            $var = $sponsorObject->viewFinances($sponsorName);
            echo json_encode($var);
            break;

        case 'addFinances':
            $invoiceNumber = $_REQUEST['invoiceNumber'];
            $amount =  $_REQUEST['amount'];
            $projectID =  $_REQUEST['projectID'];
            $var = $sponsorObject->addFinances($invoiceNumber,$amount,$projectID,$sponsorName);
            echo json_encode($var);
            break;
        
        case 'viewProjects':
            $var = $sponsorObject->viewProjects($sponsorName);
            echo json_encode($var);
            break;

        case 'viewAllProjects':
            $var = $sponsorObject->viewAllProjects();
            echo json_encode($var);
            break;

    }

