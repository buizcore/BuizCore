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
 * Dummy class for Extentions
 * This class will be loaded if the System requests for an Extention that
 * doesn't exist
 * @package net.buiz
 */
class ControllerDummy extends Controller
{

  /**
   * the controll function sends an error message to the user
   *
   * @param string $aktion
   * @return void
   */
  public function run ($aktion = null)
  {

    $this->view->setTemplate('buiz/error');

    $this->view->addVar([
      'errorTitle' => 'Wrong Extention', 'errorMessage' => 'Wrong Extention'
    ]);

  } //end public function run

} // end class ControllerDummy
