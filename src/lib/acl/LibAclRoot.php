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
 * @lang:de
 * @package net.webfrap
 */
class LibAclRoot extends BaseChild
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Cache für die gefundenen Pfad Access Daten
   * @var [int $rootId][int $level][string $refKey][string:('level'=>int "access level",'roles' => [string] "role names")]
   */
  protected $paths = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Konstruktor
   */
  public function __construct($env  )
  {
    $this->env = $env;
  }//end public function __construct */

}//end class LibAclRoot

