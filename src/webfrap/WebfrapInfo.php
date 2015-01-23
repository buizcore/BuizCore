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
 * Der Info Node über den einfach Systembezogenen Daten erfragt werden können
 * @package net.webfrap
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class WebfrapInfo
{
/*////////////////////////////////////////////////////////////////////////////*/
// Default Instance
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var WebfrapInfo
   */
  private static $defaultInstance = null;

  /**
   * @return WebfrapInfo
   */
  public static function getDefault()
  {

    if (!self::$defaultInstance)
      self::$defaultInstance = new WebfrapInfo();

    return self::$defaultInstance;

  }//end public static function getDefault */

  /**
   * @param LibConf
   */
  protected $conf = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Constructor
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function __construct()
  {

    $this->conf = BuizCore::$env->getConf();

  }//end public function __construct

  public function getSystemName()
  {
    return $this->conf->getStatus('sys_name');
  }//end public function getSystemName */

  public function getGatewayName()
  {
    return $this->conf->getStatus('gateway_name');
  }//end public function getGatewayName */

  public function getAppName()
  {
    return $this->conf->getStatus('app_name');
  }//end public function getAppName */

}//end class WebfrapInfo

