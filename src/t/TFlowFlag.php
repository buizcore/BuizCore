<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore the business core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package net.buiz
 */
class TFlowFlag
{

  /**
   * Der Inhalt des Knotens
   * @var array
   */
  protected $content = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Magic Functions
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param array $content
   */
  public function __construct($content = [])
  {

    if ($anz = func_num_args()) {
      if ($anz == 1 and is_array(func_get_arg(0))) {
        $this->content = func_get_arg(0);
      } else {
        // hier kommt auf jeden fall ein Array
        $this->content = func_get_args();
      }
    }

  } // end public function __construct */

  /**
   * Enter description here...
   *
   * @param string $key
   * @param string $value
   */
  public function __set($key , $value)
  {
    $this->content[$key] = $value;
  }// end public function __set */

  /**
   * Enter description here...
   *
   * @param string $key
   * @return string
   */
  public function __get($key)
  {
    return isset($this->content[$key])
      ? $this->content[$key]
      : null;
  }// end public function __get */

  /**
   * @param string $name
   * @return boolean
   */
  public function __isset($key){
    return isset($this->content[$key])
      ? true
      : false;
  }
  
  /**
   * @param string $key
   */
  public function exists($key)
  {
    return array_key_exists($key , $this->content);
  }//end public function exists */

} // end class TFlowFlag

