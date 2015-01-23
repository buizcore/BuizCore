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
 * Das Interface für die Logappender
 *
 * @package net.webfrap
 */
interface LibLogAdapter
{

  /** hinzufügen einer neuen Logline
   *
   * @param string  time  Zeitpunkt des Logeintrags
   * @param string  level Das Loglevel
   * @param string  file Die Datei der Loglinie
   * @param int     line Die Zeilennummer
   * @param string  message Die eigentliche Logmeldung
   * @param Exception  message Die eigentliche Logmeldung
   * @return void
   */
  public function logline($time,  $level,  $file,  $line,  $message, $exception);

} // end interface LibLogAdapter
