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
interface LibSanitizerAdapter
{

  /**
   * Methode zum entfernen unerwünschter Tags und Attribute aus HTML
   *
   * @param string $raw
   * @param string $encoding
   * @param string $configKey
   *
   * @return string
   */
  public function sanitize($raw, $encoding = 'utf-8', $configKey = 'default');

}//end class LibSanitizerAdapter

