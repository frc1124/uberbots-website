<?PHP

/* ******************************************************************************************
   * This code is licensed under the MIT License                                            *
   * Please see the license.txt file in the /omni directory for the full text               *
   * License text can also be found at: http://www.opensource.org/licenses/mit-license.php  *
   * Copyright (c) 2011 Avon Robotics                                                       *
   ******************************************************************************************

   ******************************************************************************************
   * logArch.php																			*
   * This file clears the security.txt log file and puts the contents into a new file		*
   * Developed by Phil Lopreiato                                                            *
   * Version 0.1																			*
   ******************************************************************************************/


include "../includes/common.php";

mySQLConnect();

global $root_path;

//if($_SERVER['REMOTE_ADDR']!=""){ //if calling address isn't our server (empty remote address), exit the script
//	exit;
//}

$logFile = $root_path.'/logs/module edits/foo.sql';
$query = "SELECT * FROM `moduleEdits`";

?>