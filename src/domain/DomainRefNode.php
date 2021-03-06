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
 * @author domnik alexander bonsch <dominik.bonsch@buiz.net>
 */
class DomainRefNode
{

  /**
   * @example Product Project
   * @var string
   */
  public $label = null;

  /**
   * @example Product Projects
   * @var string
   */
  public $pLabel = null;

  /**
   * @example ProjectActivity
   * @var string
   */
  public $mgmtName = null;

  /**
   * @example project_activity
   * @var string
   */
  public $srcName = null;
  

  /**
   * @var string
   */
  public $srcId = null;
  

  /**
   * @var string
   */
  public $srcRefId = null;

  /**
   * @example project_activity
   * @var string
   */
  public $connectionName = null;

  /**
   * @example project_activity
   * @var string
   */
  public $targetName = null;
  

  /**
   * @var string
   */
  public $targetId = null;
  

  /**
   * @var string
   */
  public $targetRefId = null;
  

  /**
   * @example Project
   * @var string
   */
  public $modName = null;

  /**
   * @example ProjectActivityMaskProduct
   * @var string
   */
  public $domainKey = null;

  /**
   * @example project_activity_mask_product
   * @var string
   */
  public $domainName = null;

  /**
   * @example {$name->aclKey}-ref-{$refName->name}
   * @var string
   */
  public $aclKey = null;

  /**
   * @var [DomainNode]
   */
  private static $pool = [];

  /**
   * @param string $key
   * @return DomainNode
   */
  public static function getNode($key)
  {

    if (!array_key_exists($key, self::$pool)) {

    	$keys = explode(':',$key);
    	
      $className = SParserString::subToCamelCase($keys[0]).'_Ref_'.SParserString::subToCamelCase($keys[1]).'_Domain';

      if (!BuizCore::classExists($className)) {
        self::$pool[$key] = null;
        return null;
      }

      self::$pool[$key] = new $className;
    }

    return self::$pool[$key];

  }//end public static function getNode */
  


  /**
   * @param string $key
   * @return DomainNode
   */
  public function getQBaseNode()
  {
  
    return DomainNode::getNode(($this->connectionName?$this->connectionName:$this->targetName));
  
  }//end public static function getQBaseNode */

}//end class DomainRefNode
