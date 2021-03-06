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
abstract class LibSessionAdapter implements ArrayAccess
{
/*////////////////////////////////////////////////////////////////////////////*/
// Magic Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param string $key
   * @param string $value
   */
  public function __set($key , $value)
  {
    $this->session[$key] = $value;
  }// end of public function __set($key , $value)

  /**
   * Enter description here...
   *
   * @param string $key
   * @return string
   */
  public function __get($key)
  {
    return isset($this->session[$key])?$this->session[$key]:null;
  }// end of public function __get($key)

/*////////////////////////////////////////////////////////////////////////////*/
// Interface: ArrayAccess
/*////////////////////////////////////////////////////////////////////////////*/

  public function offsetSet($offset, $value)
  {
    $this->session[$offset] = $value;
  }//end public function offsetSet($offset, $value)

  public function offsetGet($offset)
  {
    return $this->session[$offset];
  }//end public function offsetGet($offset)

  public function offsetUnset($offset)
  {
    unset($this->session[$offset]);
  }//end public function offsetUnset($offset)

  public function offsetExists($offset)
  {
    return isset($this->session[$offset])?true:false;
  }//end public function offsetExists($offset)

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $name
   * @param string $sessionId
   * @param string $sessionSavePath
   * @return void
   */
  abstract public function start($name, $sessionId = null , $sessionSavePath = null);

  /**
   * @return void
   */
  abstract public function close();

  /**
   * @return void
   */
  abstract public function destroy();

/*////////////////////////////////////////////////////////////////////////////*/
// Static Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param unknown_type $key
   * @param unknown_type $value
   * @return void
   */
  public function add($key , $value = null)
  {
    $this->session[$key] = $value;
  }

  /**
   * Enter description here...
   *
   * @param unknown_type $key
   * @param unknown_type $value
   * @return void
   */
  public function append($key , $value = null)
  {
    if (is_array($key)) {
      $this->session = array_merge($this->session,$key) ;
    } else {
      $this->session[$key][] = $value;
    }

  }//end public function append */

  /**
   * Enter description here...
   *
   * @param unknown_type $key
   * @param unknown_type $value
   * @return  mixed
   */
  abstract public function get($key)
  {
    return isset($this->session[$key])?$this->session[$key]:null;
  }//end abstract public function get */

  /**
   * Enter description here...
   *
   * @param string $key
   * @return boolean
   */
  abstract public function exists($key)
  {
    return isset($this->session[$key])?true:false;
  }

  /**
   * Enter description here...
   *
   * @param string $key
   * @return void
   */
  abstract public function delete($key)
  {
    if (isset($this->session[$key])) unset($this->session[$key]);
  }

}//end class LibSessionAdapter

