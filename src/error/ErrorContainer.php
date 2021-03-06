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
 * Hilfsklasse zum behandeln von Fehlern,
 * Wir hauptsächlich als Container für die Fehlercodes verwendet
 *
 * @package net.buiz
 *
 * @author domnik alexander bonsch <dominik.bonsch@buiz.net>
 */
class ErrorContainer
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Liste der Fehlermeldungen
   * @var array
   */
  public $messages = [];

  /**
   * Der Fehler Type
   * @see Error Constanten
   * @var string
   */
  public $code = Response::INTERNAL_ERROR;

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Neue Fehlermeldung hinzufügen
   * @param string $message
   */
  public function addMessage($message)
  {

    $this->messages[] = $message;

  }//end public function addMessage */

  /**
   * Liste mit allen Fehlermeldungen
   * @return array
   */
  public function getMessages()
  {
    return $this->message;
  }//end public function getMessages */

  /**
   * @return int den error code
   */
  public function getCode()
  {
    return $this->code;
  }//end public function getCode */

  /**
   * Die Fehler in das Response Objekt für eine Ausgabe schieben
   * @param LibResponseHttp $response
   */
  public function publish($response)
  {

    foreach ($this->messages as $message) {
      $response->addError($message);
    }

  }//end public function publish */

}//end class ErrorContainer
