<?PHP
/* ******************************************************************************************
   * This code is licensed under the MIT License                                            *
   * Please see the license.txt file in the /omni directory for the full text               *
   * License text can also be found at: http://www.opensource.org/licenses/mit-license.php  *
   * Copyright (c) 2011 Avon Robotics                                                       *
   ******************************************************************************************
   
   ******************************************************************************************
   * ical.php                                                                               *
   * This file creates a .ics (iCal file) for exprort via the calendar                      *
   * Developed by Phil Lopreiato                                                            *
   * Version 0.1																			*
   ******************************************************************************************/

header( 'Content-Type: text/calendar; charset=utf-8' );
header( 'Content-Disposition: attachment; filename=uberbotsCal.ics' );
header( 'Cache-Control: max-age=10' );

include "../includes/common.php";
global $mySQLLink;

mySQLConnect();

//begin ical
echo "BEGIN:VCALENDAR\r
	 METHOD:PUBLISH\r
	 VERSION:2.0\r
	 CALSCALE:GREGORIAN\r
	 PRODID:-//Avon Robotics//OmniCore//EN\r
	 X-WR-TIMEZONE:America/New_York\r
	 X-WR-CALNAME:UberBots Calendar";
$queryString = "";

if($_POST['exportType'] == "all"  || $_GET['exportType'] == "all"){
	$queryString = "SELECT * FROM `calendar`";
}

if($_POST['exportType'] == "future" || $_GET['exportType'] == "future"){
	$queryString = "SELECT * FROM `calendar` WHERE startTime >= ".time();
}
	
if($_POST['exportType'] == "range"){
	$start = mktime(0,0,0,mysql_real_escape_string($_POST['sMonth']),mysql_real_escape_string($_POST['sDay']),mysql_real_escape_string($_POST['sYear']));
	$end = mktime(0,0,0,mysql_real_escape_string($_POST['eMonth']),mysql_real_escape_string($_POST['eDay']),mysql_real_escape_string($_POST['eYear']));
	$queryString = "SELECT * FROM `calendar` WHERE startTime >= ".$start." AND endTime <= ".$end;
}

if($_POST['exportType'] == "single"){
	$queryString = "SELECT * FROM `calendar` WHERE id = ".mysql_real_escape_string($_POST['eventID']);
}

if($_GET['type']=="single"){
	$queryString = "SELECT * FROM `calendar` WHERE id = ".mysql_real_escape_string($_GET['id']);
}
	
if($queryString != ""){
	$query = mysql_query($queryString, $mySQLLink) or die(mysql_error());
	//add info for each event
	while($row = mysql_fetch_array($query)){

	echo 
	"\r\nBEGIN:VEVENT".
	"\r\nUID:".md5($row["id"])."@uberbots.org".
	"\r\nDTSTART:".date('Ymd\THis',$row["startTime"]).
	"\r\nDTEND:".date('Ymd\THis',$row["endTime"]).
	"\r\nDTSTAMP:".date("Ymd\THis",time()).
	"\r\nSUMMARY: UberBots - ".$row['name'].
	"\r\nDESCRIPTION: ".$row['type'].": ".$row['description']." - http://uberbots.org/e/".$row['id'].
	"\r\nLOCATION:".$row['location'].
	"\r\nEND:VEVENT";

	}
}
echo "\r\n";
?>
END:VCALENDAR