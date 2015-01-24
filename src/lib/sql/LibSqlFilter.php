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
 * @lang de:
 * Klasse zum erstellen von speziellen Filtern die in eine Criteria injected
 * werden können
 *
 * @package net.buiz
 */
class LibSqlFilter extends BaseChild
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $fieldName = null;

  /**
   * @var array
   */
  public $roles = [];

/*////////////////////////////////////////////////////////////////////////////*/
// constructor
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param array $roles
   * @param string $fieldName
   */
  public function __construct($roles = null, $fieldName = null)
  {

    $this->roles = $roles;
    $this->fieldName = $fieldName;
    
    $this->env = BuizCore::$env;

  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibSqlCriteria $criteria
   * @param Context $params
   * @return LibSqlCriteria
   */
  public function inject($criteria, $params)
  {
    return $criteria;

  }//end public function inject */

  /**
   * @param LibSqlCriteria $criteria
   * @param int $pos
   * @return LibSqlCriteria
   */
  public function filter($criteria, $pos)
  {
    return $criteria;

  }//end public function filter */

}//end class LibSqlFilter

