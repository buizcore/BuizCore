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
 * A layer above the Base Reflection Class of PHP
 *
 * @package net.webfrap
 */
class LibReflectorClass extends ReflectionClass
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param string $className
   */
  public function __construct($className)
  {

    if (is_string($className)) {
      if (!BuizCore::classExists($className)) {
        throw new Lib_Exception('Class: '.$className.' is not loadable!');
      }
    }

    parent::__construct($className);

  }//end public function __construct($className)

  /**
   * Enter description here...
   *
   * @param array $args
   * @return stdclass
   */
  public function getInstance(array $args = [])
  {
    if ($args) {
      return $this->newInstanceArgs($args);
    } else {
      return $this->newInstanceArgs();
    }
  }//end public function getInstance(array $args = [])

  /**
   * Enter description here...
   *
   * @return unknown
   */
  public function getAllMethodNames()
  {

    $methodes = [];

    foreach ($this->getMethods() as $method) {
      $methodes[] = $method->getName();
    }

    return $methodes;

  }//end public function getAllMethodNames()

} // end class LibReflectorClass

