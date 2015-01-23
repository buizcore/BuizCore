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
 * Logappender für die Ausgabe der Logmeldung in die Session
 *
 * @package net.webfrap
 */
class LibLogSession
  implements LibLogAdapter
{

  /**
   * Name der Logdaten in der Session
   * @var string
   */
  private $logName = 'SCREENLOG';

  /**
   *
   * @param $conf
   */
  public function  __construct($conf)
  {
    $this->logName = isset($conf['logname'])
      ? trim($conf['logname']):'SCREENLOG';

    $_SESSION[$this->logName] = [];

  }//end public function  __construct */

  /**
   * (non-PHPdoc)
   * @see src/i/ILogAppender#logline()
   */
  public function logline($time,  $level,  $file,  $line,  $message, $exception)
  {
    $_SESSION[$this->logName][] =  "$time\t$level\t$file\t$line\t$message\n" ;
  } // end public function logline */

} // end class LibLogSession

