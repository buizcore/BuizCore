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
class ControllerCrud extends Controller
{



  /**
   * @param LibRequest $request
   * @return ContextCrud
   */
  protected function getCrudFlags($request)
  {
    
    return new ContextCrud($request);

  } //end protected function getCrudFlags */



} // end class ControllerCrud
