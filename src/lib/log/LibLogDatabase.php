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
 * Logappender für die Postresql Datenbank
 * @package net.buiz
 *
 * @todo implement me
 *
 */
class LibLogDatabase implements LibLogAdapter
{

  /**
   * die Datenbank connection
   * @var LibDbAbstract
   */
  protected $db = null;

  /**
   * Die Tabelle in die geloggt werden soll
   */
  protected $logTable;

  /**
   * laden der Datenbank Verbindung im Constructor
   */
  public function __construct($conf)
  {
    // Datenbankverbindung zum loggen anfordern
    $this->db = Db::connection($conf['connection']);
  } // end public function __construct */

  /**
   * (non-PHPdoc)
   * @see src/i/ILogAppender#logline()
   */
  public function logline($time,  $level,  $file,  $line, $message, $exception)
  {
    $this->db->logQuery($time, $level, $file, $line, $message);
  }// end public function logline */

} // end class LibLogDatabase

