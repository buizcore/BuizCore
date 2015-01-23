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
class LibHttpError500
{

  /**
   *
   * Enter description here ...
   * @param LibTemplate $view
   */
  public function publish($view)
  {

    $view->addVar('title','500 Internal Server Error');
    $view->addVar('code','500');
    $view->addVar
    (
      'content',
      'Sorry sombeody made an error, and that\'s why you must read this unexpected message.
      If you think we made this error pleas tell us what you did before you got this message.
      We promis to fix that, and try to get better, for not wasting your time reading such useless error messages.'
    );

    $view->setTemplate('error/http/500');

  }

} // end class LibHttpError500

