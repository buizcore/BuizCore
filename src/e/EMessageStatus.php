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
class EMessageStatus
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const IS_NEW = 1;

  /**
   * @var int
   */
  const UPDATED = 2;

  /**
   * @var int
   */
  const OPEN = 3;

  /**
   * @var int
   */
  const ARCHIVED = 4;

  /**
   * @var array
   */
  public static $labels = array(
    self::IS_NEW => 'New',
    self::UPDATED => 'Updated',
    self::OPEN => 'Opened',
    self::ARCHIVED => 'Archived',
  );

  /**
   * @param string $key
   * @return string
   */
  public static function label($key)
  {
    return isset(self::$labels[$key])
      ? self::$labels[$key]
      : 'New';

  }//end public static function label */

}//end class EMessageStatus

