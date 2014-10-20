<?php
// @start snippet
include 'Services/Twilio/Capability.php';

$accountSid = 'AC50bcbef90dd37cf6f5cb5f8ef13964c9';
$authToken  = '49d0225d70d46d9e57324e98c48d3b22';

$capability = new Services_Twilio_Capability($accountSid, $authToken);
$capability->allowClientOutgoing('APa3f3e49d38f8f607c580e1d82ac82b96');
// @end snippet

$token = $capability->generateToken();
 
echo $token;
?>