<?PHP
/* ******************************************************************************************
   * This code is licensed under the MIT License                                            *
   * Please see the license.txt file in the /omni directory for the full text               *
   * License text can also be found at: http://www.opensource.org/licenses/mit-license.php  *
   * Copyright (c) 2011 Avon Robotics                                                       *
   ******************************************************************************************

   ******************************************************************************************
   * lists and adds modules AJAX support                                                    *
   * version 0.1                                                                            *
   * developed by Matt Howard, Phil Lopreiato                                               *
   ******************************************************************************************/

//NOT SURE IF FILE IS STILL IN USE, CANNOT FIND CALLER, BELIEVE DEPRECATED


//include common
include "../includes/common.php";
mySQLConnect();

$_SESSION["albumName"] = $_POST["albumName"];
$_SESSION["description"] = $_POST["description"];
$_SESSION["year"] = $_POST["year"];

echo "success"; //not sure why this is needed, if at all, but the word success was just sitting outside the php tags so I put it here instead
?>