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
 * @package net.buiz
 */
class Transaction
{

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * pool for the transactions
   * @var array
   */
  protected static $transactions = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Fake Destructor
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   */
  public function init()
  {

  }//end public function init()

  /**
   * Enter description here...
   *
   */
  public function sleep()
  {

  }//end public function sleep()

  /**
   * Enter description here...
   *
   */
  public function wakeup()
  {

  }//end public function wakeup()

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   */
  public static function createTransaction()
  {

    $sessionId = Session::getSessionId();
    $transactionId = sha1(uniqid(rand(), true));

    $className = 'SysTransaction'.$this->transactionType;

    $tansaction = new $className($transactionId, $sessionId);
    $this->transactions[$transactionId] = $tansaction;

  }//end public static function createTransaction()

  /**
   * Enter description here...
   *
   * @param string $transactionId
   * @return SysTransactionAbstract
   */
  public static function getTransaction($transactionId)
  {
    if (isset($this->transactions[$transactionId])) {
      if ($this->transactions[$transactionId]->isValid()) {
        return $this->transactions[$transactionId]->isValid();
      }
    }
    return null;
  }//end public static function getTransaction($transactionId)

  /**
   * Enter description here...
   *
   * @param unknown_type $transactionId
   */
  public static function removeTransaction($transactionId)
  {
    if ($this->transactions[$transactionId]) {
      unset($this->transactions[$transactionId]);
    }
  }//end public static function removeTransaction($transactionId)

/*////////////////////////////////////////////////////////////////////////////*/
// protected Logic
/*////////////////////////////////////////////////////////////////////////////*/

}//end class Transaction

