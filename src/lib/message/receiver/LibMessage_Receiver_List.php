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
 *
 * @package net.webfrap
 */
class LibMessage_Receiver_List implements IReceiver
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var WbfsysUserContact_Entity
   */
  public $list = null;

  /**
   * @var int
   */
  public $id = null;

  /**
   * @var string
   */
  public $name = null;

  /**
   * @var string
   */
  public $type = 'list';

  /**
   * @var array<IReceiver>
   */
  public $else = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param mixed $list
   */
  public function __construct($list)
  {

    if (is_object($list)) {
      $this->list = $list;
    } elseif (is_numeric($list)) {
      $this->id = $list;
    } else {
      $this->name = $list;
    }

  }//end public function __construct */

} // end LibMessage_Receiver_List

