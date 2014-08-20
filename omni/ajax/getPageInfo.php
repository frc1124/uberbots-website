<?PHP
/* ******************************************************************************************
   * This code is licensed under the MIT License                                            *
   * Please see the license.txt file in the /omni directory for the full text               *
   * License text can also be found at: http://www.opensource.org/licenses/mit-license.php  *
   * Copyright (c) 2011 Avon Robotics                                                       *
   ******************************************************************************************
 
   ******************************************************************************************
   * /ajax/getPageInfo.php                                                                  *
   * version 0.1                                                                            *
   * Developed by Phil Lopreiato                                                            *
   * Gets infomation about a page and returns it to the control panel for page editing      *
   ******************************************************************************************/

include "../includes/common.php";
mySQLConnect();

$permissions = userPermissions(1,2);
if($permissions){
	getPageInfo($_POST['id']);
}else{
	echo file_get_contents("http://www.uberbots.org/omni/error.php?errorCode=403");
	exit;
}

function getPageInfo($id){
	$data = "";
	$query = mysql_query("SELECT * FROM `pages` WHERE `id` = '".mysql_real_escape_string($id)."'");
	while($row = mysql_fetch_assoc($query)){
		foreach($row as $key => $value){
			switch($key){
				case "title":
					$data .= "#newTitle: ".$value.",";
					break;
				case "parentId":
					$data .= "#newParent: ".$value.",";
					break;
				case "order":
					$data .= "#newMenuOrder: ".$value.",";
					break;
				case "inheritPermissions":
					$data .= "#newInherent: ".($value==1?true:false).",";
					break;
				case "private":
					$data .= "#newPrivate: ".($value==1?true:false).",";
					break;
				case "hide":
					$data .= "#newHideBox: ".($value==1?true:false).",";
					break;
				case "redirect":
					$data .= "#newRedirectBox: ".$value.",";
					break;
			}
		}
	}
	$data = substr($data,0,-1);
	echo $data;
}
?>