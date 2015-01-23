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
 * @todo implement me
 */
class LibLogMail implements LibLogAdapter
{

  /**
   *
   * @param array $conf
   */
  public function __construct($conf)
  {

    throw NotYetImplementedException('Not yet implemented!!!');

  } // end public function __construct */

  /**
   * (non-PHPdoc)
   * @see src/i/ILogAppender#logline()
   */
  public function logline($time,  $level,  $file,  $line,  $message, $exception)
  {
    echo "$time\t$level\t$file\t$line\t$message".NL;
  } // end public function logline */

} // end class LibLogMail

