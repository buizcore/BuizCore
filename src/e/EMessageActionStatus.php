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
class EMessageActionStatus
{
/*////////////////////////////////////////////////////////////////////////////*/
// Constantes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const ANNOUNCEMENT = 0;

  /**
   * @var int
   */
  const WALLMESSAGE = 1;

  /**
   * @var array
   */
  public static $labels = [
    self::ANNOUNCEMENT => 'Announcement',
    self::WALLMESSAGE => 'Wallmessage',
  ];

  /**
   * @param string $key
   * @param string $def
   * @return string
   */
  public static function label($key, $def = null)
  {

    if (!is_null($def)) {
      
      return isset(self::$labels[$key])
        ? self::$labels[$key]
        : $def;
    
    } else {
      
      return isset(self::$labels[$key])
        ? self::$labels[$key]
        : '0';
    }

  }//end public static function label */

}// end class EMessageActionStatus

