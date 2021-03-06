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
 * @package net.buiz
 */
class LibMessage_Receiver_Contact implements IReceiver
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var BuizUserContact_Entity
   */
  public $contact = null;

  /**
   * @var id
   */
  public $id = null;

  /**
   * @var string
   */
  public $type = 'contact';

  /**
   * @var array<IReceiver>
   */
  public $else = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param mixed $contact
   */
  public function __construct($contact)
  {

    if (is_object($contact)) {
      $this->contact = $contact;
    } else {
      $this->id = $contact;
    }

  }//end public function __construct */

} // end LibMessage_Receiver_Contact

