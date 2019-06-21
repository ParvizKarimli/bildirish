<?php

date_default_timezone_set('Asia/Baku');

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

$servername = "localhost";
$username = "cl_anotherroot";
$password = "SJCA_Rass_042";
$dbname = "cl_bildirish";
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error)
{
	die("Connection failed: " . $conn->connect_error);
}

$query_get = "SELECT id, name, phone, last_payment_date, last_notified_at FROM credits";
$credits = $conn->query($query_get);
if($credits->num_rows > 0)
{
	while($credit = $credits->fetch_assoc())
	{
		/* Check when the last payment was and when the last notification was.
		   If their differences from now are greater than specified number of days,
		   then send notification to related people, and change the last notification date & time to now
		*/
		if((strtotime(date('Y-m-d')) - strtotime($credit['last_payment_date']))/86400 >= 1 &&
		(strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', strtotime($credit['last_notified_at']))))/86400 >= 1)
		{
			$to = $credit['phone'];
			$message = 'Hörmətli ' . $credit['name'] . ', sizin Okean Electronics-dən kreditlə aldığınız malın ödəmə tarixi keçmişdir. Zəhmət olmasa bu ayın ödənişini edəsiniz. Hörmətlə Okean Electronics.';

			try
			{
				if($client->messages->create(
					$to,
					array(
						'from' => $twilio_number,
						'body' => $message
					)
				))
				{
					$query_set = "UPDATE credits SET last_notified_at='" . date('Y-m-d H:i:s') . "' WHERE id=" . $credit['id'];
					$conn->query($query_set);
					echo 'SMS sent to ' . $credit['phone'] . '/' . $credit['name'] . ' successfully.<br>';
				}
			}
			catch(Exception $e)
			{
				echo $e->getMesssage();
			}
		}
	}
}
