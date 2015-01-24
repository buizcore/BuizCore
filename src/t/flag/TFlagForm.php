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
 * @author dominik alexander bonsch <dominik.bonsch@buiz.net>
 * @package net.buiz
 *
 */
class TFlagForm extends TFlag
{

  public $publish = null;

  public $targetId = null;

  public $target = null;

  public $targetMask = null;

  public $refId = null;

  public $ltype = null;

  /**
   *
   * Die Rootarea des Pfades über den wir gerade in den rechten wandeln
   * @var string $aclRoot
   */
  public $aclRoot = null;

  public $aclRootId = null;

  public $aclKey = null;

  public $aclLevel = null;

  public $aclNode = null;

} // end class TFlagForm

