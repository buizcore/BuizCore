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
class LibRichtextNode_Node extends LibRichtextNode
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $key = 'node';

  /**
   * Sollte überschrieben werden
   * @return string
   */
  public function renderValue()
  {

    $db = $this->compiler->getDb();

    $sql = <<<SQL
SELECT
  rowid,
  title
  FROM
    buiz_know_how_node
  WHERE access_key = upper('{$db->escape($this->value)}');
SQL;

    $data = $db->select($sql)->get();

    if ($data) {

    $compiled = <<<HTML
<a
  class="wcm wcm_req_ajax"
  href="maintab.php?c=Buiz.KnowhowNode.show&amp;objid={$data['rowid']}" >{$data['title']}</a>
HTML;

    } else {
      $compiled = <<<HTML
<a
  class="wcm wcm_req_ajax not_exists"
  href="maintab.php?c=Buiz.KnowhowNode.open&amp;node={$this->value}" >{$this->value}</a>
HTML;

    }

    return $compiled;

  }//end public function renderValue */

}//end class LibRichtextNode_Node

