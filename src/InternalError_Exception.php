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
 * Exception die im Controller geworfen wird um das bearbeiten einer Anfrage
 * des Benutzers entgültig ab zu brechen
 *
 * @package net.buiz
 *
 */
class InternalError_Exception extends BuizSys_Exception
{

  /**
   * @param string $message
   * @param string $debugMessage
   */
  public function __construct($message, $debugMessage = 'Internal Error')
  {

    if (!$message)
      $message = 'Sorry, the request failed';

    // passenden Fehlermeldung anhängen
    $message .=" due to an internal error. Please try again. If the problem persists please contact the system maintainer.";

    // wenn keine genaue Angabe der Fehler, dann wenigstens die standard Message nehmen
    if ('Internal Error' == $debugMessage)
      $debugMessage = $message;

    parent::__construct
    (
      $message,
      $debugMessage,
      Response::INTERNAL_ERROR
    );

  }//end public function __construct */

}//end class InternalError_Exception */

