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
 *
 * @statefull
 */
abstract class MvcModel_Domain extends MvcModel
{

  /**
   * The actual domain node
   *
   * @var DomainNode
   */
  public $domainNode = null;

  /**
   * @param Base $env
   */
  public function __construct( $domainNode = null, $env = null)
  {

    if ($domainNode)
      $this->domainNode = $domainNode;

    if (!$env)
      $env = BuizCore::getActive();

    $this->env = $env;

    $this->getRegistry();

    if (DEBUG)
      Debug::console('Load model '.get_class($this));

  }//end public function __construct */

} // end abstract class MvcModel_Domain

