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
class EUserSettingType
{
/*////////////////////////////////////////////////////////////////////////////*/
// Constantes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const MESSAGES = 1;
  const LISTING = 2;
  const LISTING_SEARCH = 3;
  const LISTING_REF = 4;
  const SELECTION = 5;

/*////////////////////////////////////////////////////////////////////////////*/
// Labels
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public static $labels = array(
    self::MESSAGES => 'Messages',
    self::LISTING => 'Listing',
    self::LISTING_SEARCH => 'Listing Search',
    self::LISTING_REF => 'Listing Ref',
    self::SELECTION => 'Selection',
  );

  /**
   * @var array
   */
  public static $classes = array(
    self::MESSAGES => 'BuizMessage_Table_Search_Settings',
    self::LISTING => 'WgtSettings_Search_Listing',
    self::LISTING_SEARCH => 'WgtSettings_Search_Listing',
    self::LISTING_REF => 'WgtSettings_Search_Listing',
    self::SELECTION => 'WgtSettings_Search_Listing',
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

  /**
   * @param string $key
   * @return string
   */
  public static function getClass($key)
  {

    return isset(self::$classes[$key])
      ? self::$classes[$key]
      : null; // sollte nicht passieren

  }//end public static function getClass */

}//end class EUserSettingType

