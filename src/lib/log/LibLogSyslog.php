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
 * Logappender für das Unix Syslogsystem
 * @package net.buiz
 */
class LibLogSyslog
  implements LibLogAdapter
{

  protected static $mapping = array
  (
  'TRACE' => LOG_DEBUG,
  'DEBUG' => LOG_DEBUG,
  'VERBOSE' => LOG_DEBUG,
  'CONFIG' => LOG_INFO,
  'INFO' => LOG_INFO,
  'USER' => LOG_NOTICE,
  'WARN' => LOG_WARNING,
  'SECURITY' => LOG_WARNING,
  'ERROR' => LOG_ERR,
  'FATAL' => LOG_ALERT
  );

  /**
   * (non-PHPdoc)
   * @see src/i/ILogAppender#logline()
   */
  public function logline($time, $level, $file, $line, $message, $exception)
  {
    syslog(self::$mapping[$level] , $time."\t".$file."\t".$line."\t".$message);
  } // end public function logline */

} // end class LibLogSyslog

