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
