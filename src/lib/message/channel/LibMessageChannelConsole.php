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
class LibMessageChannelConsole extends LibMessageChannel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  public $type = 'console';

  /**
   * (non-PHPdoc)
   * @see LibMessageChannel::getRenderer()
   */
  public function getRenderer()
  {

    if (!$this->renderer) {
      $this->renderer = new LibMessageRendererConsole();
    }

    return $this->renderer;

  }//end public function getRenderer */

  /* (non-PHPdoc)
   * @see LibMessageChannel::send()
   */
  public function send($message, $receivers)
  {
    // TODO Auto-generated method stub

  }//end public function send */

} // end LibMessageChannelConsole

