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
class LibFlowErrorHandler extends Pbase // wird nicht von Controller abgeleitet um Endless Loops zu vermeiden
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @param BuizException $error
   */
  public function handleError($request, $response, $error)
  {

    $conf = $this->getConf();

    $messageText = $error->getMessage();

    // Fallback für nicht wbf exceptions
    if (method_exists($error, 'getErrorKey'))
      $errorCode = $error->getErrorKey();
    else
      $errorCode = Response::INTERNAL_ERROR;

    $response->httpState = $errorCode;


    // bei ajax request wird einfach eine fehlermeldung geworfen
    if(
      $response->tpl->isType(View::MAINTAB)
      || $response->tpl->isType(View::MODAL)
      || $response->tpl->isType(View::AJAX)
      || $response->tpl->isType(View::SERVICE)
    ) {

      $response->sendHeader("X-error-message: ".urlencode($messageText.' '.$errorCode));
      
      if(DEBUG){
        $response->addError((string)$error);
      } else {
        $response->addError($messageText);
      }

    } elseif ($response->tpl->isType(View::DOCUMENT)) {

      // Wenn ein dokument angefragt wurde das nicht bearbeitet werden kann
      // wird eine html fehlermeldung zurückgegeben
      // meist sinnvoller als irgendetwas in ein dokument zu pinseln
      View::setType('Html');
      View::rebase('Html');


      // nach rebase wird die neue aktive templateengine geholt
      $this->tplEngine = View::getActive();

      Debug::dumpFile('doc.error', $this->tplEngine);


      //TODO prüfen ob set index und html head in der form bleiben sollen
      $viewConf = $conf->getResource('view');

      $user = $this->getUser();
      
      if ($user->getLogedIn()) {
        $this->tplEngine->setIndex('backend/desktop');
      } else {
        $this->tplEngine->setIndex($viewConf['index.annon']);
      }

      $this->tplEngine->contentType = View::CONTENT_TYPE_TEXT;

      $this->tplEngine->setIndex('error');

      $this->tplEngine->setTitle($response->i18n->l('An Error occured', 'wbf.label'));
      $this->tplEngine->setTemplate('error/message'  );
      $this->tplEngine->addVar('errorTitle' , $messageText);
      $this->tplEngine->addVar('errorMessage' , $messageText);

    } elseif ($response->tpl->isType(View::JSON)) {

      $response->tpl->setDataBody('error: '.$messageText);

    } else {

      $view = $this->getView();

      $view->setTitle($response->i18n->l('Error', 'wbf.label'));
      $view->setTemplate('error/message'  );
      $view->addVar('errorMessage', $messageText);

    }

  }//end public function handleError */


}//end class LibFlowErrorHandler
