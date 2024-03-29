<?php

date_default_timezone_set('Asia/Baku');

require 'bildirish/vendor/twilio/sdk/Twilio/autoload.php';
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$account_sid = 'AC821cd725147013b39caeabc5d3c20757';
$auth_token = '8c1e484eccaa91c54b13b1e4958d2582';
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

// A Twilio number you own with SMS capabilities
$twilio_number = "+12053509973";

$client = new Client($account_sid, $auth_token);

$servername = "localhost";
$username = "cl_anotherroot";
$password = "SJCA_Rass_042";
$dbname = "cl_bildirish";
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset('utf8mb4');
if($conn->connect_error)
{
	die("Connection failed: " . $conn->connect_error);
}

/*
   Check when the last payment was and when the last notification was.
   If their differences from now are greater than specified number of days,
   then send notification to each of the associated people, 
   and change their last notification dates & times to now.
*/
$query_get = "SELECT id, name, phone FROM credits WHERE last_payment_date <= (DATE_FORMAT(NOW(), '%Y-%m-%d') - INTERVAL 1 DAY) AND DATE_FORMAT(last_notified_at, '%Y-%m-%d') <= (DATE_FORMAT(NOW(), '%Y-%m-%d') - INTERVAL 1 DAY)";
$credits = $conn->query($query_get);
if($credits->num_rows > 0)
{
	while($credit = $credits->fetch_assoc())
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
			echo $e->getMessage();
		}
	}
}
