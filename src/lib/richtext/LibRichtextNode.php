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
 * @package net.webfrap
 *
 */
class LibRichtextNode
{

  /**
   * @var LibDbConnection
   */
  public $db = null;

  /**
   * @var User
   */
  public $user = null;

  /**
   * @var string
   */
  public $value = null;

  /**
   * @var string
   */
  public $key = null;

  /**
   * @var string
   */
  public $compiler = null;

  /**
   * @param string $value
   * @param LibRichtextCompiler $compiler
   */
  public function __construct($value, $compiler)
  {

    $this->value = $value;
    $this->compiler = $compiler;

  }//end public function __construct */

  /**
   * Sollte überschrieben werden
   * @return string
   */
  public function renderValue()
  {
    return $this->value;
  }//end public function renderValue */

  /**
   * @param string $rawContent
   * @return string
   */
  public function replaceNode($rawContent)
  {

    $newVal = $this->renderValue();
    $key = "[[{$this->key}:{$this->value}]]";

    Debug::console("replace key $key");

    return str_replace($key, $newVal, $rawContent);

  }//end public function replaceNode */

}//end class LibRichtextNode

