<?PHP
/* 	******************************************************************************************
	* This code is licensed under the MIT License                                            *
	* Please see the license.txt file in the /omni directory for the full text               *
	* License text can also be found at: http://www.opensource.org/licenses/mit-license.php  *
	* Copyright (c) 2011 Avon Robotics                                                       *
	******************************************************************************************
	******************************************************************************************
	* calForward.php																			*
	* This file takes a shorter link and forwards it to the apporpriate view event page		*
	* Developed by Phil Lopreiato                                                            *
	* Version 0.1																			*
	******************************************************************************************/

$eventId = substr($_SERVER['REQUEST_URI'],3);
if(substr($_SERVER['REQUEST_URI'],0,3) == "/e/" && is_numeric($eventId)){
	echo file_get_contents("http://uberbots.org/o/calendar?viewEvent&eventId=".$eventId);
}else{
	echo file_get_contents("http://uberbots.org/omni/error.php?errorCode=404");}
?>