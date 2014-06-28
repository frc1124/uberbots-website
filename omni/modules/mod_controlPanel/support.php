<?PHP
/* ******************************************************************************************
   * This code is licensed under the MIT License                                            *
   * Please see the license.txt file in the /omni directory for the full text               *
   * License text can also be found at: http://www.opensource.org/licenses/mit-license.php  *
   * Copyright (c) 2011 Avon Robotics                                                       *
   ******************************************************************************************

   ******************************************************************************************
   * Control Panel Module - Get Logs                                                        * 
   * Supports showing logged activities                                                     *
   * version 0.1                                                                            *
   * Developed by Phil Lopreiato                                                            *
   ******************************************************************************************/
include "../../includes/common.php";
mySQLConnect();

if($_GET['type']=='logs'){
	$output = "<div id=\"logList\" name=\"logList\">";
	$output .= "Old Logs:\n";
	$dir = "/home1/uberbots/public_html/omni/logs/";
	if (is_dir($dir)) {
		if($handle = opendir($dir)){
		$output .= "<br><ul>";
		while (false != ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if($file != "security.txt" && $file != "error_log" && $file != "index.php" && $file != "mass emails"){
					$output .= "<li><a href=\"http://uberbots.org/omni/logs/".$file."\" target=\"_blank\">".$file."</a></li>";
				}
			}
		}
		$output .= "</div>";
		closedir($handle);
		}
	}else{
		$output .= "not directory";
	}
	echo $output;
}

if($_GET['type']=='email'){
	$output = "<div id='logList' name='logList'>\nOld Emails:\n";
	$dir = "/home1/uberbots/public_html/omni/logs/mass emails";
	
	$files = scandir($dir);
	unset($files[0]);
	unset($files[1]);
	foreach($files as $key=>$value){
		$output .= "<li><a href=\"http://uberbots.org/omni/logs/mass emails/".$value."\" target=\"_blank\">".$value."</a></li>";
	}
	echo $output."</div>";
}

if($_GET['type']=='showPermissions'){
		$query = mysql_query("SELECT * FROM `pagePermissions`");
		
		$permissionOutput .= "<h3>Special Permissions List</h3><style type='text/css'>#permissionTable {width:100%;}
#permissionTable TD {padding:5px;width:20%;}</style><table id='permissionTable'><tr><td><b>User ID</b></td><td><b>Username</b></td><td><b>Page ID</b></td><td><b>Page Name</b></td><td><b>Permission Type</b></td></tr>";
		while ($row = mysql_fetch_array($query)){
			
			if ($row['access'] == 1)
				$type = "Modify";
			elseif ($row['access'] == 0)
				$type = "View";
				
			$name = mysql_fetch_row(mysql_query("SELECT * FROM `pages` WHERE `id`='".$row['pageId']."'"));
			$permissionOutput .= "<tr><td>".$row['id']."</td><td>".$row['name']."</td><td>".$row['pageId']."</td><td>".$name[2]."</td><td>".$type."</td></tr>";
		}
		$permissionOutput .= "</table><br/><a href='javascript:void(0)' onclick='$(\"#permissions\").hide()'>Hide Permission List</a>";
		echo $permissionOutput;
	}

?>