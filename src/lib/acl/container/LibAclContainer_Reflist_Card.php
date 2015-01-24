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
 * @author dominik alexander bonsch <dominik.bonsch@buiz.net>
 */
class LibAclContainer_Reflist_Card extends LibAclContainer_Reflist
{

  public function fetchListDefault($query, $condition, $params)
  {
    return $this->injectListAcls($query, $condition, $params);
  }
  
}//end class LibAclContainer_Reflist_Card

