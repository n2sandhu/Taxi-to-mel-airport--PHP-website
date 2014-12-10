<?php
session_start();
date_default_timezone_set('Australia/Melbourne');
$today = date("Y-m-d");
$todayTime = date("h:m");
/*include "connection.php";*/
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$time = $_POST['time'];
$persons = $_POST['persons'];
$car = $_POST['car'];
$pUnit = $_POST['pUnit'];
$pAddress = $_POST['pAddress'];
$pSuburb = $_POST['pSuburb'];
$fno = $_POST['fNo'];
$bno = $_POST['bNo'];
$dUnit = $_POST['dUnit'];
$dAddress = $_POST['dAddress'];
$dSuburb = $_POST['dSuburb'];
$notes = $_POST['notes'];

if(empty($fno))
{
	$fno = "NA";
}
if(empty($bno))
{
	$bno = "NA";
}
if(empty($notes))
{
	$notes = "NONE";
}
if($date < $today)
{
	$_SESSION['name'] = $name;
	$_SESSION['email'] = $email;
	$_SESSION['phone'] = $phone;
	$_SESSION['date'] = $date;
	$_SESSION['time'] = $time;
	$_SESSION['car'] = $car;
	$_SESSION['pAddress'] = $pAddress;
	$_SESSION['pUnit'] = $pUnit;
	$_SESSION['pSuburb'] = $pSuburb;
	$_SESSION['dUnit'] = $dUnit;
	$_SESSION['dAddress'] = $dAddress;
	$_SESSION['dSuburb'] = $dSuburb;
	$_SESSION['notes'] = $notes;
	 $_SESSION['flash_message'] ='The selected date is in the past.Please select a present or future date';
  	header('Location: booking.php');
    exit();
}
if($time < $todayTime)
{
	$_SESSION['name'] = $name;
	$_SESSION['email'] = $email;
	$_SESSION['phone'] = $phone;
	$_SESSION['date'] = $date;
	$_SESSION['time'] = $time;
	$_SESSION['car'] = $car;
	$_SESSION['pAddress'] = $pAddress;
	$_SESSION['pUnit'] = $pUnit;
	$_SESSION['pSuburb'] = $pSuburb;
	$_SESSION['dUnit'] = $dUnit;
	$_SESSION['dAddress'] = $dAddress;
	$_SESSION['dSuburb'] = $dSuburb;
	$_SESSION['notes'] = $notes;
	 $_SESSION['flash_message'] ='The selected time has already passed. Please select a valid time';
  	header('Location: booking.php');
    exit();
}
function checkDateFormat($date)
{
  //match the format of the date
  if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
  {
    //check weather the date is valid of not
        if(checkdate($parts[2],$parts[3],$parts[1]))
          return true;
        else
         return false;
  }
  else
    return false;
}
if(!checkDateFormat($date))
{
	 $_SESSION['flash_message'] ='Date is invalid. Date should be in the format YYYY-MM-DD';
  	header('Location: booking.php');
    exit();
}
$to = $email;
$to2 = "info@taxi2melbourneairport.com.au";
$subject = "Details of Taxi booking";
$subject2 = "Booking request made";
$message= <<<EMAIL
Your booking has been saved. Here are the details:
Name: $name
Phone: $phone
Date: $date
Time: $time
Type of Car : $car
Pick up Address: $pUnit, $pAddress, $pSuburb
Flight No.: $fno
Number of Briefcase : $bno
Drop off Address: $dUnit, $dAddress, $dSuburb
Note for Driver: $notes

IF THE DETAILS ARE NOT CORRECT OR YOU WANT TO MAKE CHANGES OR CANCEL
THE BOOKING CONTACT US ON info@taxi2melbourneairport.com.au OR
CALL US ON +61 43383 6698

EMAIL;
$message2 = <<<EMAIL
An online booking has been made. Here are the details:
Name: $name
Phone: $phone
Date: $date
Time: $time
Type of Car : $car
Pick up Address: $pUnit $pAddress $pSuburb
Flight No.: $fno
Number of Briefcase : $bno
Drop off Address: $dUnit $dAddress $dSuburb
Note for Driver: $notes

EMAIL;
$header = "From: info@taxi2melbourneairport.com.au";

/*$resultVerify = mysql_query("SELECT * FROM website_info WHERE title = '$title'");
$rows = mysql_num_rows($resultVerify);*/

if($name == "" || $phone == "" || $date == "" || $time == "" || $car=="" || $pAddress == "" || $pSuburb == ""  || $dSuburb == "")
{
		$_SESSION['name'] = $name;
	$_SESSION['email'] = $email;
	$_SESSION['phone'] = $phone;
	$_SESSION['date'] = $date;
	$_SESSION['time'] = $time;
	$_SESSION['car'] = $car;
	$_SESSION['pAddress'] = $pAddress;
	$_SESSION['pUnit'] = $pUnit;
	$_SESSION['pSuburb'] = $pSuburb;
	$_SESSION['dUnit'] = $dUnit;
	$_SESSION['dAddress'] = $dAddress;
	$_SESSION['dSuburb'] = $dSuburb;
	$_SESSION['notes'] = $notes;
    $_SESSION['flash_message'] ='Fill in all the fields that does not say OPTIONAL';
  	header('Location: booking.php');
    exit();
}
elseif(strlen($phone) != 10 || !is_numeric($phone) )
{
	$_SESSION['name'] = $name;
	$_SESSION['email'] = $email;
	$_SESSION['phone'] = $phone;
	$_SESSION['date'] = $date;
	$_SESSION['time'] = $time;
	$_SESSION['car'] = $car;
	$_SESSION['pAddress'] = $pAddress;
	$_SESSION['pUnit'] = $pUnit;
	$_SESSION['pSuburb'] = $pSuburb;
	$_SESSION['dUnit'] = $dUnit;
	$_SESSION['dAddress'] = $dAddress;
	$_SESSION['dSuburb'] = $dSuburb;
	$_SESSION['notes'] = $notes;
	$_SESSION['flash_message'] ='Phone number must consist of 10 digits. Example: 0404114565 or 0394563451';
  	header('Location: booking.php');
    exit();
}
else
{

	$send = mail($to, $subject, $message, $header);	
	$_SESSION['flash_message1'] ='Thank you for your booking.. soon you will be contacted by one of our team members confirming your booking. `'; 	
	$send2 = mail($to2, $subject2, $message2,$header);
	if (!$send) {
		 $_SESSION['flash_message'] ='There was an error making your booking. Please try again';
	  	header('Location: booking.php');
	    exit();
	}
	header('Location: booking.php');
	    exit();
	
}