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
 * Basisklasse für Error hanlder Controller
 *
 * @package net.buiz
 */
class ControllerErrorBase extends Controller
{

/*////////////////////////////////////////////////////////////////////////////*/
// Der Controller
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $action
   */
  public function run ($action = null)
  {

    $this->showErrorPage();

  } //end public function run

/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function showErrorPage ()
  {

    $this->view->setTemplate('ModError', 'errors');

  } // end public function errorPage

} // end class MexCoreBase

