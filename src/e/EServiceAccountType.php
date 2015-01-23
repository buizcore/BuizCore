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
class EServiceAccountType
{
/*////////////////////////////////////////////////////////////////////////////*/
// Constantes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const POP3 = 1;

  /**
   * @var int
   */
  const IMAP = 2;

  /**
   * @var int
   */
  const EXCHANGE = 3;

  /**
   * @var array
   */
  public static $labels = array(
    self::POP3 => 'Pop3',
    self::IMAP => 'Imap',
    self::EXCHANGE => 'MS Exchange',
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
        : '';
    }

  }//end public static function label */

}// end class EMessageActionStatus

