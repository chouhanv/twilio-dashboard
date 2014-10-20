<?php
@session_start(); 
include "Services/Twilio/Capability.php";
 
// AccountSid and AuthToken can be found in your account dashboard
$accountSid = 'AC50bcbef90dd37cf6f5cb5f8ef13964c9';
$authToken  = '49d0225d70d46d9e57324e98c48d3b22';
 
// The app outgoing connections will use:
$appSid = "APa3f3e49d38f8f607c580e1d82ac82b96"; 
 
// The client name for incoming connections:
$clientName = $_REQUEST['caller'];
$access_token = $_REQUEST['access_token'];
$lat = $_REQUEST['lat'];
$lng = $_REQUEST['lng'];
 
$_SESSION["callerid"] = $clientName;
$_SESSION["caller_access_token"] = $access_token;
$_SESSION["callerlat"] = $lat;
$_SESSION["callerlng"] = $lng;

$capability = new Services_Twilio_Capability($accountSid, $authToken);
 
// This allows incoming connections as $clientName: 
$capability->allowClientIncoming($clientName);
 
// This allows outgoing connections to $appSid with the "From" 
// parameter being the value of $clientName 
$capability->allowClientOutgoing($appSid, array(), $clientName);
 
// This returns a token to use with Twilio based on 
// the account and capabilities defined above 
$token = $capability->generateToken();
 
echo $token;
?>