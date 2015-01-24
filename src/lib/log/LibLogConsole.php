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
 * Logappender der einfach die Logmeldungen sammelt
 * @package net.buiz
 */
class LibLogConsole implements LibLogAdapter
{

  /**
   * (non-PHPdoc)
   * @see src/i/ILogAppender#logline()
   */
  public function logline($time,  $level,  $file,  $line, $message, $exception)
  {

    $logMessage = 'Log '.$level.': '.$message.' '.$time." ".$file." ".$line;
    echo $logMessage.NL;

  }// end public function logline */

} // end class LibLogConsole

