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
class EClientOs
{

  const WINDOWS = 1;

  const LINUX = 2;

  const SOLARIS = 3;

  const BSD = 4;

  const MAC = 5;

  /**
   * Minimale liste potentiell vorhandener serverbetriebsysteme
   *
   * @var array
   */
  public static $text = array
  (
    self::WINDOWS => 'Windows',
    self::LINUX => 'Linux',
    self::SOLARIS => 'Solaris',
    self::BSD => 'BSD',
    self::MAC => 'MacOsX'
  );

}//end class ECoreClientOs

