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
 * serializer to xml
 * @package net.webfrap
 */
class LibSerializerBin extends LibSerializerAbstract
{

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * instance of the
   *
   * @var ObjSerializerXml
   */
  private static $instance = null;

  /**
   *
   * @var array
   */
  protected $data = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Singleton
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return ObjSerializerXml
   */
  public static function getInstance()
  {

  }
/* (non-PHPdoc)
 * @see LibSerializerAbstract::serialize()
 */
  public function serialize($data = null)
  {

    // TODO Auto-generated method stub

  }
//end public static function getInstance()

/*////////////////////////////////////////////////////////////////////////////*/
// Add Validator
/*////////////////////////////////////////////////////////////////////////////*/

} // end class LibSerializerBin

