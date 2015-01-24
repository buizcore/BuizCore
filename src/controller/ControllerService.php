<?php

/*******************************************************************************
 *
 * @author      : Dominik Bonsch <dominik.bonsch@buiz.net>
 * @date        :
 * @copyright   : Buiz Developer Network <contact@buiz.net>
 * @project     : Buiz Web Frame Application
 * @projectUrl  : http://buiz.net
 *
 * @licence     : BSD License see: LICENCE/BSD Licence.txt
 *
 * @version: @package_version@  Revision: @package_revision@
 *
 * Changes:
 *
 *******************************************************************************/

/**
 *
 * @package net.buiz
 * @author dominik alexander bonsch <dominik.bonsch@buiz.net>
 *
 */
class ControllerService extends Controller
{

  /**
   * @param string $methodeName
   * @param string $view
   */
  public function runIfCallable ($methodeName = null, $view = null)
  {

    $request = $this->getRequest();
    $response = $this->getResponse();

    if (is_null($methodeName))
      $methodeName = $this->activAction;

    if (method_exists($this, 'service_' . $methodeName)) {
      $methodeName = 'service_' . $methodeName;
      //$request, $response
      try {

        $error = $this->$methodeName($request, $response);

        if ($error && is_object($error)) {
          $this->errorPage($error);
        }

      } catch (Buiz_Exception $error) {
        $this->errorPage($error);
      } catch (Buiz $error) {
        $this->errorPage($error->getMessage(), Response::INTERNAL_ERROR);
      }

      return;
    } else {
      if (DEBUG)
        Debug::console($methodeName . ' is not callable!', $this->callAble);

      $response->addError('The action :' . $methodeName . ' is not callable!');

      $this->errorPage('The Action :' . $methodeName . ' is not callable!', Response::NOT_FOUND);

      return;
    }


  } //end public function runIfCallable */

  /**
   * get the form flags for this management
   * de:
   * {
   * prüfen ob die standard steuer flags vorhanden sind
   * }
   * @param TFlag $params
   * @return TFlag
   */
  protected function getFlags ($request)
  {
    return new ContextDefault($request);

  } //end protected function getFlags */



  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getCrudFlags ($request)
  {
    return new ContextCrud($request);

  } //end protected function getCrudFlags */



} // end class ControllerService
