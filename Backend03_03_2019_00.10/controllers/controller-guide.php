<?php
$guideID = $_REQUEST['guideID'];
/*$guideID = 'GD1';
$variablePath = "This is the way";
$documentDescription = 'This Review';
$projectID = 'PD101';
$description = 'progress_report_4';
$document_name = 'Hanoz_is_brother_of_linus.';
$invoiceNumber = 'HDFC0002314';
$amount = 69;*/

require_once '../models/model-guide.php';
$guideObject = new ModelGuide;
require_once '../PHPMailer/mail.php';
global $mail;

$action = $_REQUEST['action'];
//
    switch($action){

        case 'viewDocuments':
            $projectID = $_REQUEST['projectID'];
            $var = $guideObject->viewDocuments($guideID,$projectID);
            echo json_encode($var);
            break;

        case 'addDocuments':
            $variablePath = $_REQUEST['variablePath'];
            $documentDescription = $_REQUEST['documentDescription'];
            $projectID = $_REQUEST['projectID'];
            $document_name = $_REQUEST['$document_name'];
            $var6 = $guideObject->addDocuments($variablePath,$document_name,$documentDescription,$projectID);
            echo json_encode($var6);
            break;

        case 'viewProjects':
            $var = $guideObject->viewProjects($guideID);
            echo json_encode($var);
            break;

        case 'approveDocuments':
            $projectID = $_REQUEST['projectID'];
            $description = $_REQUEST['description'];
            $var = $guideObject->approveDocuments($projectID,$description);
            echo json_encode($var);

            $mail->isHTML(true);
            $mail->Subject = "Document Approval";
            $mail->Body = $var['case'];
            $mail->AltBody = "This is the plain text version of the email content";

            for ($i = 0; $i < $var['size']; $i++)
            {
                $mail->addAddress($var[$i]['email']);
                $mail->send();
            }

            break;

        case 'disapproveDocuments':
            $projectID = $_REQUEST['projectID'];
            $description = $_REQUEST['description'];
            $var = $guideObject->disapproveDocuments($projectID,$description);
            echo json_encode($var);
            
            $mail->isHTML(true);
            $mail->Subject = "Document Dispproval";
            $mail->Body = $var['case'];
            $mail->AltBody = "This is the plain text version of the email content";

            for ($i = 0; $i < $var['size']; $i++)
            {
                $mail->addAddress($var[$i]['email']);
                $mail->send();
            }

            break;

        case 'viewFinances':
            $var = $guideObject->viewFinances($guideID);
            echo json_encode($var);
            break;

        case 'viewSelf':
            $var4 = $guideObject->viewSelf($guideID);
            echo json_encode($var4);
            break;

        case 'addFinances':
            $invoiceNumber = $_REQUEST['invoiceNumber'];
            $amount = $_REQUEST['amount'];
            $projectID = $_REQUEST['projectID'];       
            $var5 = $guideObject->addFinances($invoiceNumber,$amount,$projectID,$guideID);
            echo json_encode($var5);
            break;
        
            case 'viewApprovedDocuments':
            $projectID = $_REQUEST['projectID'];
            $var4 = $guideObject->viewApprovedDocuments($guideID,$projectID);
            echo json_encode($var4);
            break;

        case 'viewFinanced':
            $var4 = $guideObject->viewFinanced($guideID);
            echo json_encode($var4);
            break;

        case 'viewSelf':
            $var4 = $guideObject->viewSelf($guideID);
            echo json_encode($var4);
            break;

        case 'viewNotifications':
            $var4 = $guideObject->viewNotifications($guideID);
            echo json_encode($var4);
            break;

    }





//addFinances($invoiceNumber,$amount,$projectID,$guideID)