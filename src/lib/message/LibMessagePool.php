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
 */
class LibMessagePool
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var array
   */
  protected $errors = [];

  /**
   *
   * @var array
   */
  protected $errorDblCheck = [];

  /**
   *
   * @var array
   */
  protected $warnings = [];

  /**
   *
   * @var array
   */
  protected $messages = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Wichtige Resoucen
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var LibDbConnection
   */
  protected $db = null;

  /**
   * @var Base
   */
  protected $env = null;

  /**
   * Klasse über welche die relevanten Adressdaten zu versenden der Nachricht
   * gezogen werden
   *
   * @var LibMessageAddressloader
   */
  protected $addressModel = null;

/*////////////////////////////////////////////////////////////////////////////*/
// constructor
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Base $env
   */
  public function __construct($env = null)
  {

    if ($env)
      $this->env = $env;
    else
      $this->env = BuizCore::$env;

  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// getter + setter für die Resourcen
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibDbConnection $db
   */
  public function getDb()
  {

    if (!$this->db)
      $this->db = $this->env->getDb();

    return $this->db;

  }//end public function getDb */

  /**
   * @param LibDbConnection $db
   */
  public function setDb($db)
  {
    $this->db = $db;
  }//end public function setDb */

/*////////////////////////////////////////////////////////////////////////////*/
// Messaging System
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $error
   * @param string $stream
   */
  public function addError($error, $stream = 'stdout')
  {

    if (!isset($this->errors[$stream])) {
      $this->errors[$stream] = [];
      $this->errorDblCheck[$stream] = [];
    }

    if (DEBUG) {
      if (is_array($error))
        Debug::console("ERROR: ".implode(NL, $error));
      else
        Debug::console("ERROR: ".$error);
    }

    ///TODO implement also for arrays
    if (!is_array($error) && isset($this->errorDblCheck[$stream][$error])) {
      Debug::console("Redundant error: ".$error,null, true);

      return;
    } else {

      if(is_array($error) )
        Debug::console("GOT error: ".implode($error),$error, true);
      else
        Debug::console("GOT error: ".$error,null, true);
    }

    if (is_array($error)) {

      foreach ($error as $errorMsg) {

        $errorMsgKey = md5(trim($errorMsg));
        if (!isset($this->errorDblCheck[$stream][$errorMsgKey])) {
          $this->errorDblCheck[$stream][$errorMsgKey] = true;
          $this->errors[$stream][] = $errorMsg;
        }
      }

    } else {

      $errorMsgKey = md5(trim($error));
      if (!isset($this->errorDblCheck[$stream][$errorMsgKey])) {
        $this->errorDblCheck[$stream][$errorMsgKey] = true;
        $this->errors[$stream][] = $error;
      }
    }

  }//end public function addError */

  /**
   * @param string $stream
   */
  public function resetErrors($stream = 'stdout')
  {
    unset($this->errors[$stream]);
  }//end public function resetErrors */

  /**
   * @param string $stream
   * @return boolean
   */
  public function hasErrors($stream = 'stdout')
  {
    return (isset($this->errors[$stream])) ?true:false;
  }//end public function resetErrors */

  /**
   * @param $stream
   * @return array
   */
  public function getErrors($stream = 'stdout')
  {
    return isset($this->errors[$stream]) ?$this->errors[$stream]:[];
  }//end public function getErrors */

  /**
   * @param $stream
   * @return array
   */
  public function cleanErrors($stream = 'stdout')
  {

    if (isset($this->errors[$stream]))
      unset($this->errors[$stream]);

  }//end public function cleanErrors */

  /**
   * @param string $warning
   * @param string $stream
   */
  public function addWarning($warning  , $stream = 'stdout')
  {
    if (!isset($this->warnings[$stream]))
      $this->warnings[$stream] = [];

    if (is_array($warning)) {
      $this->warnings[$stream] = array_merge($this->warnings[$stream], $warning);
    } else {
      $this->warnings[$stream][] = $warning;
    }

  }//end public function addWarning */

  /**
   * @param string $stream
   */
  public function resetWarnings($stream = 'stdout')
  {
    unset($this->warnings[$stream]);
  }//end public function resetWarnings */

  /**
   * @param string $stream
   * @return boolean
   */
  public function hasWarnings($stream = 'stdout')
  {
    return isset($this->warnings[$stream]) ?true:false;

  }//end public function hasWarnings */

  /**
   * @param string $stream
   * @return array
   */
  public function getWarnings($stream = 'stdout')
  {
    return isset($this->warnings[$stream]) ?$this->warnings[$stream]:[];

  }//end public function getWarnings */

  /**
   * @param string $message
   * @param string $stream
   */
  public function addMessage($message, $stream = 'stdout')
  {

    if (!isset($this->messages[$stream]))
      $this->messages[$stream] = [];

    if (is_array($message)) {
      $this->messages[$stream] = array_merge($this->messages[$stream], $message);
    } else {
      $this->messages[$stream][] = $message;
    }

  }//end public function addMessage */

  /**
   * @param string $stream
   */
  public function resetMessages($stream = 'stdout')
  {

    unset($this->messages[$stream]);

  }//end public function resetMessages */

  /**
   *
   * @param string $stream
   * @return boolean
   */
  public function hasMessages($stream = 'stdout')
  {
    return isset($this->messages[$stream]) ?true:false;

  }//end public function hasMessages */

  /**
   * alle Systemnachrichten aus einem Chanel holen
   * @param string $stream
   * @return array
   */
  public function getMessages($stream = 'stdout')
  {
    return isset($this->messages[$stream]) ?$this->messages[$stream]:[];

  }//end public function getMessages */

/*////////////////////////////////////////////////////////////////////////////*/
// State
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Ein State Object zum verarbeiten übergeben
   * Es werden Messages, Warnings und Errors soweit vorhanden ausgegelesen
   *
   * @param State $state
   */
  public function handleState($state)
  {

    if ($state->errors)
      $this->addError($state->errors);

    if ($state->warnings)
      $this->addWarning($state->warnings);

    if ($state->messages)
      $this->addMessage($state->messages);

  }//end public function handleState */

/*////////////////////////////////////////////////////////////////////////////*/
// Protocol
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param string $message
   * @param string $context
   * @param Entity $entity
   * @param string $mask
   */
  public function protocol($message, $context, $entity = null, $mask = null  )
  {

    $orm = $this->getDb()->getOrm();

    if ($entity) {
      if (is_array($entity)) {
        $resourceId = $orm->getResourceId($entity[0]);
        $entityId = $entity[1];
      } elseif (is_numeric($entity)) {
        $resourceId = null;
        $entityId = $entity;
      } elseif (is_string($entity)) {
        $resourceId = $orm->getResourceId($entity);
        $entityId = null;
      } else {
        $resourceId = $orm->getResourceId($entity);
        $entityId = $entity->getId();
      }
    } else {
      $resourceId = null;
      $entityId = null;
    }

    $protocol = new BuizProtocolMessage_Entity();
    $protocol->message = $message;
    $protocol->context = $context;
    $protocol->vid = $entityId;
    $protocol->id_vid_entity = $resourceId;
    $protocol->mask = $mask;

    $orm->send($protocol);

  }//end public function protocol */

/*////////////////////////////////////////////////////////////////////////////*/
// Messages
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibMessageStack $message
   *
   * @throws LibMessage_Exception
   *
   */
  public function send($message)
  {

    // alle relevanten empfänger laden
    $addressModel = $this->getAddressModel();

    // die addresierten Channel laden
    $channels = $this->getMessageChannels($message);

    foreach ($channels as $channel) {
      // adressen laden
      $receivers = $addressModel->getReceivers($message->getReceivers(), $channel->type);
      $channel->send($message, $receivers);
    }

  }//end public function send */

  /**
   * @return LibMessageAddressloader
   */
  public function getAddressModel()
  {

    if (!$this->addressModel)
      $this->addressModel = new LibMessageAddressloader();

    return $this->addressModel;

  }//end public function getAddressModel */

  /**
   * @param array $groups
   * @param string $type
   * @param string $area
   * @param Entity $entity
   *
   * @return array<LibMessageReceiver>
   */
  public function getGroupUsers($groups, $type, $area = null, $entity = null, $direct = false)
  {

    if (!$this->addressModel)
      $this->addressModel = new LibMessageAddressloader();

    $receiver = new LibMessage_Receiver_Group(
      $groups,
      $area,
      $entity
    );

    return $this->addressModel->getGroupUsers($receiver, $type, $direct);

  }//end public function getGroupUsers */

  /**
   * @param array $groups
   * @param string $type
   * @param string $area
   * @param Entity $entity
   *
   * @return array<LibMessageReceiver>
   */
  public function getDsetUsers($entity, $type, $area = null)
  {

    if (!$this->addressModel)
      $this->addressModel = new LibMessageAddressloader();

    $receiver = new LibMessage_Receiver_Group(
      null,
      $area,
      $entity
    );

    return $this->addressModel->getGroupUsers($receiver, $type);

  }//end public function getDsetUsers */

  /**
   * @param array<LibMessageReceiver> $receivers
   * @param string $type
   *
   * @return array<LibMessageReceiver>
   */
  public function getReceivers($receivers, $type = Message::CHANNEL_MAIL)
  {

    if (!$this->addressModel)
      $this->addressModel = new LibMessageAddressloader();

    return $this->addressModel->getReceivers($receivers , $type  );

  }//end public function getReceivers */

  /**
   *
   * Alle Nachrichtenkanäle laden über welche die Nachricht verschickt werden soll
   *
   * @param LibMessageStack $message
   *
   * @return array<LibMessageChannel>
   *
   * @throws LibMessage_Exception wenn einer der angefragten Message Channel nicht existiert
   */
  public function getMessageChannels($message)
  {

    $channelObjects = [];

    $channelKeys = $message->getChannels();

    foreach ($channelKeys as $key) {

      $className = "LibMessageChannel".ucfirst($key);

      if (BuizCore::classExists($className)) {
        $chan = new $className();
        $channelObjects[$key] = $chan;
      } else {
        throw new LibMessage_Exception("The requested Message Channel ".ucfirst($key).' not exists!');
      }

    }

    return $channelObjects;

  }//end public function getMessageChannels */

}// end LibMessagePool

