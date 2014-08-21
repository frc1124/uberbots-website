<?php
if ($_GET['randomId'] != "SCJBnDrLtDi1me_01wYgvy38shDP2tT4TgQ3b7YD4oionqvk7hWCV7GtDa29QB0X") {
    echo "Access Denied";
    exit();
}
// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);
?>  