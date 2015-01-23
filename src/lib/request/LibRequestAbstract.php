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
 * @package net.webfrap
 *
 */
abstract class LibRequestAbstract
{

  /**
   *
   * @var LibMessagePool
   */
  protected $messages = null;

  /**
   *
   * @param $messages
   * @return unknown_type
   */
  public function setMessage($messages)
  {
    $this->messages = $messages;
  }//end public function setMessage($messages)

}// end abstract class LibRequestAbstract

