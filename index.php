<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 11/30/18
 * Time: 12:55 PM
 */

$rawBody = file_get_contents('php://input');
$getBody = $_GET;
$posBody = $_POST;

if(!empty($rawBody) || !empty($getBody) || !empty($posBody)) {
    $body = "NEW Request:\n";
    $body .= "Sent From: ".$_SERVER['REMOTE_ADDR']."\n";

    $body .= "\nGET Request Data:\n";
    foreach ($_GET as $k=>$v) {
        $body .= "*\t".$k.":\t".$v."\n";
    }

    $body .= "\nPOST Request Data:\n";
    foreach ($_POST as $k=>$v) {
        $body .= "*\t".$k.":\t".$v."\n";
    }

    $body .= "\nRAW Request Data:\n";
    $body .= file_get_contents('php://input')."\n";

    $body .= "\nSupplemental Data:\n";
    foreach($_SERVER as $k=>$v) {
        $body .= "*\t".$k.":\t".$v."\n";
    }

    $body .= "\n\n\n";
    $filename = date('m-d-Y_H:i:s').".txt";

    $bytes = file_put_contents(getcwd().'/captures/'.$filename,$body,FILE_APPEND);

    if($bytes !== false) {
        file_put_contents("log.txt",date('m/d/Y H:i:s').": New request stored in captures/".$filename."\n",FILE_APPEND);
        echo "Request Stored Successfully: ".$filename;
    } else {
        file_put_contents("log.txt",date('m/d/Y H:i:s').": ERROR - Unable to store new request.\n",FILE_APPEND);
        echo "Unable to write body of request to file.";
    }
}
