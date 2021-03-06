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
 * @author Dominik Bonsch <dominik.bonsch@buiz.net>
 * @copyright Buiz Developer Network <contact@buiz.net>
 * @package net.buiz
 */
class ECoreErrorLevel
{

  const DISPLAY = 1;

  const LIGHT = 2;

  const MODERATE = 3;

  const HEAVY = 4;

  const BLOCKER = 5;

  /**
   * Key Map
   * @var array
   */
  public static $text = array
  (
    self::DISPLAY => 'wbf.enum.errorlevel.Display',
    self::LIGHT => 'wbf.enum.errorlevel.Light',
    self::MODERATE => 'wbf.enum.errorlevel.Moderate',
    self::HEAVY => 'wbf.enum.errorlevel.Heavy',
    self::BLOCKER => 'wbf.enum.errorlevel.Blocker',
  );

}//end class ECoreErrorLevel

