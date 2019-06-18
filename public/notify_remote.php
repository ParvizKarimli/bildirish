<?php

date_default_timezone_set('Asia/Baku');

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
			$to = 'devparviz@gmail.com';
			$subject = 'Bildirish Notification';
			$message = 'This is a notification to ' . $credit['phone'] . '/' . $credit['name'];
			$headers = "From:Bildirish<noreply@example.com>";

			if(mail($to, $subject, $message, $headers))
			{
				$query_set = "UPDATE credits SET last_notified_at='" . date('Y-m-d H:i:s') . "' WHERE id=" . $credit['id'] . "";
				$conn->query($query_set);
				echo 'Notification sent to ' . $credit['phone'] . '/' . $credit['name'] . '<br>';
			}
		}
	}
}
