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
class SCheckHtml
{

  /**
   * @param string $allClasses
   * @param string $classToCheck
   */
  public static function hasClass($allClasses, $classToCheck)
  {

    $tmp = explode(' ', $allClasses);

    if (in_array($classToCheck, $tmp))
      return true;

    return false;

  }//end public static function hasClass */

}// end class SCheckHtml

