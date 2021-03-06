<?PHP
/* ******************************************************************************************
   * This code is licensed under the MIT License                                            *
   * Please see the license.txt file in the /omni directory for the full text               *
   * License text can also be found at: http://www.opensource.org/licenses/mit-license.php  *
   * Copyright (c) 2011 Avon Robotics                                                       *
   ******************************************************************************************/

/* OmniCore
*  Version 0.1
*  Developed by Matt Howard, Phil Lopreiato
*  OmniCore
*/

//include 'common'.'Common' contains all necessary includes.
include "includes/common.php";

//connect to mySQL
mySQLConnect();

//get page info
$page = new url();
$page->init();

//user permissions (security.php)
$editable = userPermissions(1);

if($page->error404 || !userPermissions(0)){
	header("HTTP/1.0 404 Not Found");
	echo file_get_contents("http://www.uberbots.org/omni/error.php?errorCode=404");
	exit;
}

//create menu
$menu = drawMenu();

//render final output
$skinVars = array();
$skinVars["additionalHead"] = "";
$skinVars["mainColumn"] = renderModules($page->pageId);
$skinVars["secondColumn"] = renderModules(0);
$skinVars["title"] = $page->title;
$skinVars["currentPage"] = $page->fullUrl;
$skinVars["sessionId"] = $user->data["session_id"];
$skinVars["pageId"] = $page->pageId;
$skinVars["topMenu"] = $menu[0];
$skinVars["secondMenu"] = $menu[1];
$skinVars["breadcrumbs"] = $page->breadCrumbs();

$options = array("ISHOME"=>($page->pageId==1),"MOBILE_COOKIE"=>isset($_COOKIE['skin']));
	
//html tidy
// Specify configuration
$config = array(
           'indent'         => true,
		   'doctype'		=> "user",
           'wrap'           => 200);


$html = parseSkin($skinVars,"main",$options);

// Tidy
$tidy = new tidy;
$tidy->parseString($html, $config, 'utf8');
$tidy->cleanRepair();

//testing/debbugging
echo("<div title='This can be modified in core.php' style='margin-left:4px;margin-top:4px;color:grey;position:fixed;background-color:rgba(0,0,0,0.8);z-index:99999;border:black;border-radius:2px;border-style:solid'>");
echo("<strong>Debug Info</strong>");
echo("</br>");
echo("Group ID: ");
echo($user->data["group_id"]);
echo("</br>");
echo("User ID: ");
echo($user->data["user_id"]);
echo("</br>");
echo("Version: ");
echo("beta_stable_cleaned");
echo("</div>");

//output page
echo $html;
?>