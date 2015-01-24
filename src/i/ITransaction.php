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
interface ITransaction
{

/*////////////////////////////////////////////////////////////////////////////*/
// Interface Logic Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * start a transaction
   * @return void
   */
  public function begin();

  /**
   * sucessfully end a transaction
   *
   */
  public function commit();

  /**
   * rollback if a transaction fails
   *
   */
  public function rollback();

}// end interface ITransaction

