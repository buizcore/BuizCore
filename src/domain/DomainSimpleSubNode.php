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
 * Simple helper node for subdomain keys
 * like names of elements
 *
 * @package net.buiz
 *
 * @author domnik bonsch <dominik.bonsch@buiz.net>
 */
class DomainSimpleSubNode
{

  /**
   * @example project_activity
   * @var string
   */
  public $key = null;

  /**
   * @example project/activity
   * @var string
   */
  public $mask = null;

  /**
   * @param stringt $key
   */
  public function __construct($key)
  {

    $this->key = $key;
    $this->mask = SFormatStrings::subToCamelCase($key);

  }//end public function __construct */

}//end class DomainSimpleSubNode
