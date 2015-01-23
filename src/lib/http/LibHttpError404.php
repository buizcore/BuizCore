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
  * Php Backend für die Internationalisierungsklasse
 * @package net.webfrap
  */
class LibHttpError404
{

  /**
   *
   * Enter description here ...
   * @param LibTemplate $view
   */
  public function publish($view)
  {

    $view->addVar('title','404 Not Found');
    $view->addVar('code','404');
    $view->addVar
    (
      'content',
      'Hi, that what you requested not exists.'
    );

    $view->setTemplate('error/http/404');

  }//end public function publish */

} // end class LibHttpError404

