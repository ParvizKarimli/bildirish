<?php

require 'bildirish/vendor/twilio/sdk/Twilio/autoload.php';
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$account_sid = 'AC6ea9472cf9874c2d7fa191e65a4dea8d';
$auth_token = 'e83d42870437773ad58d0909a38d7614';
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

// A Twilio number you own with SMS capabilities
$twilio_number = "+12512998603";

$client = new Client($account_sid, $auth_token);
if($client->messages->create(
    // Where to send a text message (your cell phone?)
    '+994555349081',
    array(
        'from' => $twilio_number,
        'body' => 'I sent this message in under 10 minutes, Parviz!'
    )
))
{
	echo 'SMS sent successfully.';
}
