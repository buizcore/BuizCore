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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package net.webfrap
 */
class ECoreProOpType
{

  /**
   * it's an url
   * @var int
   */
  const URL = 1;

  /**
   * it's an action
   * @var int
   */
  const ACTION = 2;

  /**
   * Key map
   * @var array
   */
  public static $text = array
  (
    self::URL => 'core.enum.type.url',
    self::ACTION => 'core.enum.type.action',
  );

}//end class ECoreProOpType

