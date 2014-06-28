<?PHP
/* ******************************************************************************************
   * This code is licensed under the MIT License                                            *
   * Please see the license.txt file in the /omni directory for the full text               *
   * License text can also be found at: http://www.opensource.org/licenses/mit-license.php  *
   * Copyright (c) 2011 Avon Robotics                                                       *
   ******************************************************************************************/

/*Abstract module class
* version 0.1
* Developed by Phil Lopreiato
*/

abstract class abstractModule{
	
	public $modName;
	
	abstract public function render();
	abstract public function rednerEdit();
	abstract public  function edit();

}

?>