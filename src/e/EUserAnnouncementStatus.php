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
class EUserAnnouncementStatus
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  const IS_NEW = 1;

  const OPEN = 2;

  const ARCHIVED = 3;
  
  /**
   * @var array
   */
  public static $labels = array(
      self::IS_NEW => 'New',
      self::OPEN => 'Open',
      self::ARCHIVED => 'Archived',
  );

} // end class EUserAnnouncementStatus

