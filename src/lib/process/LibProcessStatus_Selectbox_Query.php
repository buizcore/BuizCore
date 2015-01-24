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
 * @author Dominik Donsch <dominik.bonsch@buiz.net>
 *
 */
class LibProcessStatus_Selectbox_Query extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  public $processName = null;

  public $processId = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Query Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Fetch method for the Process Selectbox
   * @return void
   */
  public function fetchSelectbox()
  {

    if (!$this->processName && !$this->processId) {
      // ohne process id werden keine statusnodes geladen
      $this->data = [];

      return;
    }

    $db = $this->getDb();

    if (!$this->criteria)
      $criteria = $db->orm->newCriteria();
    else
      $criteria = $this->criteria;

    $criteria->select(array
    (
      'buiz_process_node.rowid as id',
      'buiz_process_node.label as value'
     ));

    $criteria->from('buiz_process_node');

    if ($this->processId) {
      $criteria->where('buiz_process_node.id_process = '.$this->processId);
    } else {

      $criteria->leftJoinOn
      (
        'buiz_process_node',
        'id_process',
        'buiz_process',
        'rowid',
        null,
        'buiz_process'
      );

      $criteria->where('buiz_process.access_key = \''.$this->processName."'");
    }

    $criteria->orderBy('buiz_process_node.m_order');

    $this->result = $db->orm->select($criteria);

  }//end public function fetchSelectbox */

}//end class LibProcessStatus_Selectbox_Query

