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
class EMessageTaskStatus
{
/*////////////////////////////////////////////////////////////////////////////*/
// Constantes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const OPEN = 1;

  /**
   * @var int
   */
  const REJECTED = 2;

  /**
   * @var int
   */
  const RUNNING = 3;

  /**
   * @var int
   */
  const WAITING = 4;

  /**
   * @var int
   */
  const ABORTED = 5;

  /**
   * @var int
   */
  const COMPLETED = 6;

  /**
   * @var array
   */
  public static $labels = array(
    self::OPEN => 'Open',
    self::REJECTED => 'Rejected',
    self::RUNNING => 'Running',
    self::WAITING => 'Waiting',
    self::ABORTED => 'Aborted',
    self::COMPLETED => 'Completed',
  );

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
        : 'Offen';
    }

  }//end public static function label */

}// end class EMessageTaskStatus

