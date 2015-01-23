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
class LibEncodeDummy
{

  /**
   * @var LibI18n
   */
  public $i18n = null;

  /**
   * @param string $from
   * @param string $to
   */
  public function __construct()
  {

    $this->i18n = BuizCore::$env->getI18n();

  }//end public function __construct */

  /**
   * @param string $pwd
   */
  public function encode($string)
  {
    return $string;
  }//end public static function encode */

  /**
   * check for hidden redirects in the url
   * @return string
   */
  public function i18n($key, $repo, $data = [])
  {
    return $this->i18n->l($key, $repo, $data);

  }//end function function i18n */

} // end class LibEncodeDummy

