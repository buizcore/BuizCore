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
 * @author Dominik Bonsch <dominik.bonsch@buiz.net>
 * @copyright Buiz Developer Network <contact@buiz.net>
 */
class EBuizConfidential
{
/*////////////////////////////////////////////////////////////////////////////*/
// Constantes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const PUBLICLY = 0;

  /**
   * @var int
   */
  const CUSTOMER = 1;

  /**
   * @var int
   */
  const RESTRICTED = 2;

  /**
   * @var int
   */
  const CONFIDENTIAL = 3;

  /**
   * @var int
   */
  const SECRET = 4;

  /**
   * @var int
   */
  const TOP_SECRET = 5;

  /**
   * @var array
   */
  public static $labels = array(
    self::PUBLICLY => 'Public',
    self::CUSTOMER => 'Customer Only',
    self::RESTRICTED => 'Internal',
    self::CONFIDENTIAL => 'Confidential',
    self::SECRET => 'Secret',
    self::TOP_SECRET => 'Top Secret',
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
        : self::$labels[self::PUBLICLY];
    }


  }//end public static function label */

}// end class EBuizConfidential

