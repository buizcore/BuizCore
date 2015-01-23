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
 */
class ValidStructure
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public $data = [];

  /**
   * @var LibResponseHttp
   */
  public $response = null;

  /**
   * @var Base
   */
  public $env = null;

  /**
   * Flag ob es fehler gab
   * @var boolean
   */
  public $hasError = false;

/*////////////////////////////////////////////////////////////////////////////*/
// Constructor
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var LibResponseHttp $response
   * @var Base $env
   */
  public function __construct($response, $env = null)
  {
    $this->response = $response;

    if ($env)
      $this->env = $env;
    else
      $this->env = BuizCore::$env;

  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// Method
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $message
   */
  public function addError($message)
  {

    $this->hasError = true;
    $this->response->addError($message);

  }//end public function addError */

  /**
   * @param string $message
   */
  public function addWarning($message)
  {

    $this->response->addWarning($message);

  }//end public function addWarning */

  /**
   * @param string $key
   * @param string $subKey
   * @return array | null
   */
  public function getData($key = null, $subKey = null)
  {

    if (!is_null($subKey))
      return isset($this->data[$key][$subKey])?$this->data[$key][$subKey]:null;

    if (!is_null($key))
      return isset($this->data[$key])?$this->data[$key]:[];

     return $this->data;

  }//end public function getData */

} // end class ValidStructure

