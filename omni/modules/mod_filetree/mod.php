<?PHP
/* ******************************************************************************************
   * This code is licensed under the MIT License                                            *
   * Please see the license.txt file in the /omni directory for the full text               *
   * License text can also be found at: http://www.opensource.org/licenses/mit-license.php  *
   * Copyright (c) 2011 Avon Robotics                                                       *
   ******************************************************************************************/

/*Filetree Module
* version 0.1
* Developed by Matt Howard
* Uses PHP File Tree By A Beautiful Site LLC.
* http://abeautifulsite.net/blog/2007/06/php-file-tree/
*/

class mod_filetree {
	
	public $title = 'Filetree';
	public $description = 'Displays a filetree';
	public $path = 'mod_filetree';

	public function render($properties) {
		global $root_path;
		include "php_file_tree.php";
		$isEditable = userPermissions(1);
		if(!isset($properties["path"]))
		$properties["path"]="/media/files";
		
		//move/rename/new folder etc. actions
		if($isEditable&&isset($_POST["command"])){
			$command = explode(",",$_POST["command"]);
			if ($command[0]=="new")
				mkdir($root_path.$properties["path"]."/New Directory");
			if ($command[0]=="move"){
				rename($this->omniToGlobal($command[1]),$this->omniToGlobal($command[2].substr($command[1],strrpos($command[1],"/"))));
				echo $comand[1];
				}
			if ($command[0]=="delete"){
				$this->recursiveDelete($this->omniToGlobal($command[1]));
				}
			if ($command[0]=="rename"){
				rename($this->omniToGlobal($command[1]),$this->omniToGlobal(substr($command[1],0,1+strrpos($command[1],"/"))).$command[2]);
				}
			}
		
		$code = "<link href=\"/omni/modules/mod_filetree/styles/default/default.css\" rel=\"stylesheet\" type=\"text/css\" title=\"filetree style\" itemprop=\"filetree\"/>";
		
		if($isEditable){
			$code .= "<script src=\"/omni/modules/mod_filetree/editing.js\" type=\"text/javascript\"></script>
					  <form method=\"POST\">
					  <p>
					  <button onclick='addAction(\"move\");' type=\"button\" description =\"Click 'move', then a file or folder to move, then a destination folder.\" class='actionButton'>Move</button>
					  <button onclick='addAction(\"delete\")' type=\"button\" description =\"Click 'delete', then a file or folder to delete.\" class='actionButton'>Delete</button>
					  <button onclick='addAction(\"rename\")' type=\"button\" description =\"Click 'rename', then a file or folder to rename, and enter the desired new name.\" class='actionButton'>Rename</button>
					  <button onclick='window.location=\"files_and_documents/upload\"' type=\"button\" description =\"Click 'upload' to be redirected to an upload page.\" class='actionButton'>Upload</button>
					  <button onclick='addAction(\"new\")' type=\"button\" description =\"Click 'New Folder', then enter a name for the new folder.\" class='actionButton'>New Folder</button></p>
					  <div id=\"actionDescription\">&nbsp;</div>
					  <input type=\"hidden\" name=\"command\" id=\"commandField\"/>
					  </form>
					  <style type\"text/css\">
					  	.jqifade{
						position: absolute;
						background-color: #aaaaaa;
					}
					div.jqi{
						width: 400px;
						font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
						position: absolute;
						background-color: #ffffff;
						font-size: 11px;
						text-align: left;
						border: solid 1px #eeeeee;
						border-radius: 10px;
						-moz-border-radius: 10px;
						-webkit-border-radius: 10px;
						padding: 7px;
					}
					div.jqi .jqicontainer{
						font-weight: bold;
					}
					div.jqi .jqiclose{
						position: absolute;
						top: 4px; right: -2px;
						width: 18px;
						cursor: default;
						color: #bbbbbb;
						font-weight: bold;
					}
					div.jqi .jqimessage{
						padding: 10px;
						line-height: 20px;
						color: #444444;
					}
					div.jqi .jqibuttons{
						text-align: right;
						padding: 5px 0 5px 0;
						border: solid 1px #eeeeee;
						background-color: #f4f4f4;
					}
					div.jqi button{
						padding: 3px 10px;
						margin: 0 10px;
						background-color: #2F6073;
						border: solid 1px #f4f4f4;
						color: #ffffff;
						font-weight: bold;
						font-size: 12px;
					}
					div.jqi button:hover{
						background-color: #728A8C;
					}
					div.jqi button.jqidefaultbutton{
						background-color: #BF5E26;
					}
					.jqiwarning .jqi .jqibuttons{
						background-color: #BF5E26;
					}
					</style>";
		}
		$code .= '
			<script src="/omni/modules/mod_filetree/php_file_tree_jquery.js" type="text/javascript"></script>
			'.php_file_tree($root_path.$properties["path"],"/omni".$properties["path"]."/");
		return $code;
	}

	public function renderEdit($properties) {
		return "<label for='tree_".$properties["pageId"]."_".$properties["instanceId"]."' style='display:inline-block;width:150px;'>Filetree Root Path: </label><input name='tree_".$properties["pageId"]."_".$properties["instanceId"]."' id='tree_".$properties["pageId"]."_".$properties["instanceId"]."' value='".$properties["path"]."'/><br/><button onclick=\"saveMod(".$properties["pageId"].",".$properties["instanceId"].",{path:$('#tree_".$properties["pageId"]."_".$properties["instanceId"]."').val()})\">Save</button>";
	}

	public function edit($properties) {
		setVariables(mysql_real_escape_string($properties['pageId']),mysql_real_escape_string($properties['instanceId']),array('path'=>$properties['path']));
	}
	
	var $sqlNames, $sqlDefaults;
	
	public function setup() {
		$this->sqlNames = array("path");
		$this->sqlDefaults = array("/media/files/");
	}
	
	private function omniToGlobal($filepath){
		//convert "omni/media..." to global path
		global $root_path;
		
		return $root_path.substr($filepath,5);
	}
	
	private function recursiveDelete($str){
        if(is_file($str)){
            return @unlink($str);
        }
        elseif(is_dir($str)){
            $scan = glob(rtrim($str,'/').'/*');
            foreach($scan as $index=>$path){
                recursiveDelete($path);
            }
            return @rmdir($str);
        }
    }
}
