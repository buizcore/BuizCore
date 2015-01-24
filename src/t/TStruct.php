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
 *
 * @package net.buiz
 * @author Dominik Bonsch <dominik.bonsch@buiz.net>
 * @author Malte Schirmacher <malte.schirmacher@buiz.net>
 * @copyright Buiz Developer Network <contact@buiz.net>
 */
abstract class TStruct
{

/*////////////////////////////////////////////////////////////////////////////*/
// Magic Functions
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * do not set to set unknown properties
   *
   * @param string $key
   * @param unknown_type $value
   */
  public function __set ($key, $value)
  {

    throw new RuntimeException ('Property "' . $key . '" is unknown');
  } // end of public function __set($key , $value)

  /**
   * do not set to get unknown properties
   *
   * @param string $key
   * @return unknown
   */
  public function __get ($key)
  {

    throw new RuntimeException ('Property "' . $key . '" is unknown');
  } // end of public function __get($key)

} // end class TStruct

