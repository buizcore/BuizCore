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
 * @package net.webfrap
 *
 */
class TEnum
  implements ArrayAccess, Iterator, Countable
{

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  protected $pool = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Magic Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function construct()
  {

    $anz = func_get_args();

    if ($anz) {
      $this->pool = $anz;
    } else {
      $this->pool = [];
    }

  }//end public function __construct()

/*////////////////////////////////////////////////////////////////////////////*/
// Interface: ArrayAccess
/*////////////////////////////////////////////////////////////////////////////*/

  public function offsetSet($offset, $value)
  {
    $this->pool[$offset] = $value;
  }//end public function offsetSet($offset, $value)

  public function offsetGet($offset)
  {
    return $this->pool[$offset];
  }//end public function offsetGet($offset)

  public function offsetUnset($offset)
  {
    unset($this->pool[$offset]);
  }//end public function offsetUnset($offset)

  public function offsetExists($offset)
  {
    return isset($this->pool[$offset])?true:false;
  }//end public function offsetExists($offset)

/*////////////////////////////////////////////////////////////////////////////*/
// Interface: Iterator
/*////////////////////////////////////////////////////////////////////////////*/

  public function current ()
  {
    return current($this->pool);
  }//end public function current ()

  public function key ()
  {
    return key($this->pool);
  }//end public function key ()

  public function next ()
  {
    return next($this->pool);
  }//end public function next ()

  public function rewind ()
  {
    reset($this->pool);
  }//end public function rewind ()

  public function valid ()
  {
    return current($this->pool)? true:false;
  }//end public function valid ()

/*////////////////////////////////////////////////////////////////////////////*/
// Interface: Countable
/*////////////////////////////////////////////////////////////////////////////*/

  public function count()
  {
    return count($this->pool);
  }//end public function count()

}//end class TEnum

