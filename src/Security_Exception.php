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
 * Die Exception die durch die Gegend fliegt wenn Sicherheitsprobleme fest
 * gestell werden
 * @package net.buiz
 *
 */
class Security_Exception extends Buiz_Exception
{

  /**
   * de:
   * Standard Code ist forbidden
   * @var int
   */
  public $code = Response::FORBIDDEN;

}

