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
class LibFormatterFactory
{

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $languageData = [];

  /**
   * @var ObjFormatterFactory
   */
  protected $instance = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Singleton Factory
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public static function createInstance()
  {
    self::$instance = new LibFormatterFactory();
  }//end public static function createInstance

/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return
   */
  public static function getDateFormatter()
  {
    if (is_null(self::$instance)) {
      self::createInstance();
    }

  }//end public static function getDateFormatter

} // end class LibFormatterFactory

