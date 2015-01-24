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
 * Static Interface to get the activ configuration object
 * @package net.buiz
 *
 */
class Event extends BaseChild
{
/*////////////////////////////////////////////////////////////////////////////*/
// static attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Action Pool
   * @var array
   */
  public static $pool = [];

/*////////////////////////////////////////////////////////////////////////////*/
// pool logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param string $key
   * @param string $classname
   *
   * @throws Lib_Exception
   */
  public static function getEvent($key, $classname)
  {

    if (!isset(self::$pool[$key])) {
      if (!BuizCore::classExists($classname)) {
        throw new Lib_Exception('Requested nonexisting Action: '.$classname.' key '.$key);
      } else {
        self::$pool[$key] = new $classname();
      }
    }

    return self::$pool[$key];

  }//end public static function getEvent */

}// end class Event
