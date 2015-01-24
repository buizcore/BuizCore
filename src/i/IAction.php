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
 * Abstract Class For SysExtention Controllers
 *
 * @package net.buiz
 */
interface IAction
{

  /**
   * the run method
   * @param mixed $input
   * @return boolean
   */
  public static function run($input);

} // end interface IAction
