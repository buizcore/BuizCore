<?php

/*******************************************************************************
 *
 * @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @date        :
 * @copyright   : Webfrap Developer Network <contact@webfrap.net>
 * @project     : Webfrap Web Frame Application
 * @projectUrl  : http://webfrap.net
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
 * @package net.webfrap
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 *
 */
class ControllerFrontend extends Controller
{

  /*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getCrudFlags ($request = null)
  {

    if (! $request)
      $request = BuizCore::$env->getRequest();

    return new ContextCrud($request);
    
  } //end protected function getCrudFlags */


} // end class ControllerFrontend
