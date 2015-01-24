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
