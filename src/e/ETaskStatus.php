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
 */
class ETaskStatus
{
/*////////////////////////////////////////////////////////////////////////////*/
// constantes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const OPEN = 0;

  /**
   * @var int
   */
  const RUNNING = 2;

  /**
   * @var int
   */
  const WAITING = 3;

  /**
   * @var int
   */
  const COMPLETED = 4;

  /**
   * @var int
   */
  const FAILED = 5;

  /**
   * @var int
   */
  const DISABLED = 6;

  /**
   * @var int
   */
  const DELETED = 7;

/*////////////////////////////////////////////////////////////////////////////*/
// Labels
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public static $labels = array(
    self::OPEN => 'Open',
    self::RUNNING => 'Running',
    self::WAITING => 'Waiting',
    self::COMPLETED => 'Completed',
    self::FAILED => 'Failed',
    self::DISABLED => 'Disabled',
    self::DELETED => 'Deleted',
  );

  /**
   * @param string $key
   * @return string
   */
  public static function label($key)
  {
    return isset(self::$labels[$key])
      ? self::$labels[$key]
      : self::$labels[self::OPEN]; // no status? so it's open

  }//end public static function label */

}//end class ETaskType

