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
 * @package net.buiz
 */
class LibSerializerXml extends LibSerializerAbstract
{

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * instance of the serializer
   *
   * @var ObjSerializerXml
   */
  private static $instance = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Singleton
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return ObjSerializerXml
   */
  public static function getInstance()
  {

    if (is_null(self::$instance)) {
      self::$instance = new LibSerializerXml();
    }

    return self::$instance;

  }//end public static function getInstance()

/*////////////////////////////////////////////////////////////////////////////*/
// Add Validator
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param mixed $data
   */
  public function serialize($data = null)
  {

    $this->serialized = '<data>'.NL;
    $this->serialized .= $this->serializeNode($data);
    $this->serialized .= '</data>'.NL;

  }//end public function serialize($data = null)

  /**
   * Enter description here...
   * @param mixed
   */
  protected function serializeNode($data)
  {

    if (is_scalar($data)) {
      return (string) $data;
    } elseif (is_array($data)) {
      $xml = '<array >'.NL;

      foreach ($data as $key => $value) {

      }

      $xml .= '</array>'.NL;

      return $xml;
    } elseif (is_object($data) and $data instanceof ISerializeable  ) {

    } else {
      throw new LibSerializerException
      (
        I18n::s('wbf.error.unserializeable')
      );
    }

    return null;

  }//end protected function serializeNode()

  /**
   * Enter description here...
   *
   * @param scalar $data
   */
  protected function serializeScalar($data)
  {

  }//end protected function serializeScalar($data)

  /**
   * Enter description here...
   *
   * @param array $data
   */
  protected function serializeArray($data)
  {

  }//end protected function serializeArray($data)

  /**
   * Enter description here...
   *
   * @param object $data
   */
  protected function serializeObject($data)
  {

  }//end protected function serializeObject($data)

} // end class LibSerializerXml

