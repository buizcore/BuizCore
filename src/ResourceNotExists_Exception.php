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
 * Is used when a service requested by the user not exists.
 *
 * @package net.buiz
 */
class ResourceNotExists_Exception extends BuizUser_Exception
{

  /**
   *
   * @param string $message
   * @param string $debugMessage
   * @param int $errorKey
   */
  public function __construct(
    $message = 'The requested resource does not exist.' ,
    $debugMessage = 'Not Found',
    $errorKey = Response::NOT_FOUND
  ) {

    $request = BuizCore::$env->getRequest();
    $response = BuizCore::$env->getResponse();

    $response->setStatus($errorKey);

    if (is_object($message)) {

      if (DEBUG && 'Not Found' != $debugMessage)
        parent::__construct($debugMessage);
      else
        parent::__construct($message->getMessage());

      $this->error = $message;

      $this->debugMessage = $debugMessage;
      $this->errorKey = $message->getId();

      if ('cli' == $request->type)
        $response->writeLn($debugMessage);

      Error::addException($debugMessage, $this);
      
    } else {
      
      if (DEBUG && 'Not Found' != $debugMessage && !is_numeric($debugMessage))
        parent::__construct($debugMessage);
      else
        parent::__construct($message);

      $this->debugMessage = $debugMessage;
      $this->errorKey = $errorKey;

      if ('cli' == $request->type)
        $response->writeLn($message);

      Error::addException($message , $this);
    }

  }//end public function __construct */

}

