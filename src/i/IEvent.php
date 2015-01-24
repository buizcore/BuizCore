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
 * @package net.buiz
 */
interface IEvent
{

  /**
   * @param string $event
   * fire an event
   */
  public function fireEvent($event);

  /**
   * @param string $event
   * @param string $eventName
   * @param string $action
   */
  public static function addEvent($event , $eventName , $action);
  
  /**
   */
  public static function saveEvent();

} // end interface IEvent
