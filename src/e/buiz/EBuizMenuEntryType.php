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
class EBuizMenuEntryType
{
/*////////////////////////////////////////////////////////////////////////////*/
// Constantes
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   * @var int
   */
  const ROOT = 1;

  /**
   * @var int
   */
  const SUBMENU = 2;

  /**
   * @var int
   */
  const ENTRY = 3;


/*////////////////////////////////////////////////////////////////////////////*/
// Labels
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public static $labels = array(
    self::ROOT => 'Root',
    self::SUBMENU => 'Submenu',
    self::ENTRY => 'Entry',
  );

  /**
   * @param string $key
   * @return string
   */
  public static function label($key)
  {

    return isset(self::$labels[$key])
      ? self::$labels[$key]
      : null; // sollte nicht passieren

  }//end public static function label */


}//end class EBuizMenuEntryType

