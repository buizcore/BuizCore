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
 * class Controller
 * Extention zum verwalten und erstellen von neuen Menus in der Applikation
 * @package net.buiz
 */
abstract class Model extends BaseChild
{
/*////////////////////////////////////////////////////////////////////////////*/
// Public Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die vorhadenen Registry keys
   * @var array
   */
  protected $regKeys = [];

  /**
   * sub Modul Extention
   * @var array
   */
  protected $subModels = [];

  /**
   * Error Object zum sammeln von Fehlermeldungen
   * @var Error
   */
  protected $error = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Constructor
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Base $env
   */
  public function __construct($env = null)
  {

    if (!$env)
      $env = BuizCore::getActive();

    $this->env = $env;

    $this->getRegistry();

  }//end public function __construct */


/*////////////////////////////////////////////////////////////////////////////*/
// registry methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * get data from the registry of the model
   * @param string $key
   * @return mixed
   */
  public function getRegisterd($key)
  {
    return isset($this->registry[$key])
      ?$this->registry[$key]
      :null;

  }//end public function getRegisterd */

  /**
   * a data to the registry in the model
   * @param string $key
   * @param mixed $value
   * @return void
   */
  public function register($key, $value)
  {
    $this->regKeys[$key] = true;
    $this->registry[$key] = $value;
  }//end public function register */

  /**
   * a data to the registry in the model
   * @param string $key
   * @param mixed $value
   * @return void
   */
  public function protocol($message, $context = null, $object = null, $mask = null)
  {

    $this->getResponse()->protocol($message, $context, $object, $mask);

  }//end public function protocol */

  /**
   * @param string $type
   * @param mixed $where
   * @return Entity
   */
  public function getGenericEntity($type, $where)
  {
    return $this->getOrm()->get($type, $where);

  }//end public function getGenericEntity */

  /**
   * Die Registry leeren
   * @return void
   */
  public function reset()
  {

    if (!$this->regKeys)
      return;

    if ($keys = array_keys($this->regKeys)) {
      foreach ($keys as $key) {
        if (isset($this->registry[$key]))
          unset($this->registry[$key]);
      }
    }

  }//end public function reset */

  /**
   * request the default action of the ControllerClass
   * @param string $modelKey
   * @param string $key
   * @return Model
   */
  public function loadModel($modelKey, $key = null)
  {

    if (!$key)
      $key = $modelKey;

    $modelName = $modelKey.'_Model';
    $modelNameOld = 'Model'.$modelKey;

    if (!isset($this->subModels[$key]  )) {
      if (!BuizCore::classExists($modelName)) {
        $modelName = $modelNameOld;
        if (!BuizCore::classExists($modelName)) {
          throw new Controller_Exception('Internal Error', 'Failed to load Submodul: '.$modelName);
        }
      }

      $this->subModels[$key] = new $modelName($this);

    }

    return $this->subModels[$key];

  }//end public function loadModel */

  /**
   *
   * @param string $key
   * @return Model
   */
  public function getModel($key)
  {

    if (isset($this->subModels[$key]))
      return $this->subModels[$key];
    else
      return null;

  }//public function getModel */

/*////////////////////////////////////////////////////////////////////////////*/
// Error handling
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $message
   */
  public function addError($message)
  {

    if (!$this->error)
      $this->error = new ErrorContainer();

    $this->error->addMessage();

  }//end public function addError */

  /**
   * @return boolean
   */
  public function hasError()
  {
    return isset($this->error);

  }//end public function hasError */

  /**
   * @return boolean
   */
  public function getError()
  {
    return $this->error;
  }//end public function getError */

} // end abstract class Model

