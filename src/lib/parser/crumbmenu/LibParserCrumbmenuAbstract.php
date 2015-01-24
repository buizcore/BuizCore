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
abstract class LibParserCrumbmenuAbstract
{

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @var Logsys
   */
  protected $log = null;

  /**
   * Enter description here...
   *
   * @var array
   */
  protected $data = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Magic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function __construct($data)
  {
    $this->data = $data;

  }//end public function __construct

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->build();

  }//end public function __toString

/*////////////////////////////////////////////////////////////////////////////*/
// Parser
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  abstract public function build();

} // end class ObjParserCrumbmenuAbstract

