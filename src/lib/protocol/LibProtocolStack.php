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
 * Class to create simple protocols
 * @package net.buiz
 *
 */
class LibProtocolStack
{

  public $stack = [];

  /** Default constructor
   *  the conf and open a file
   *
   */
  public function __construct()
  {

  }//end public function __construct */

  /** Schreiben der Loglinie in das Logmedium
   *
   *
   * @param string message Die eigentliche Logmeldung
   * @return

   */
  public function write($message)
  {

    $this->stack[] = $message;

  } // end public function write */

  /**
   * Leere des Protocol Stacks
   */
  public function clear()
  {
    $this->stack = [];
  }//end protected function clear */

  public function render()
  {
    return implode(NL, $this->stack);

  }//end public function render */

} // end LibProtocolStack

