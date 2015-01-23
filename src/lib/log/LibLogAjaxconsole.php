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
 *
 * @package net.webfrap
 */
class LibLogAjaxconsole implements LibLogAdapter
{

  /**
   *
   * @var array
   */
  public static $loglines = [];

  /**
   * (non-PHPdoc)
   * @see src/i/ILogAppender#logline()
   */
  public function logline($time,  $level,  $file,  $line,  $message, $exception)
  {
    $logMessage = 'Log '.$level.': '.$message.' '.$time." ".$file." ".$line;

    Debug::console($logMessage);

  } // end public function logline */

} // end class LibLogAjaxconsole

