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
class LibFormatterMoney
{

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
   * Enter description here...
   *
   * @var LibFormatterMoney
   */
  protected static $instance = null;

  /**
   * @var string
   */
  protected $moneyEnglish = null;

  /**
   * @var string
   */
  protected $moneyLanguage = null;

  /**
   * @var string
   */
  protected $separatorDec = ',';

  /**
   * @var string
   */
  protected $separatorTh = '.';

  /**
   * @var int
   */
  protected $size =  2;

/*////////////////////////////////////////////////////////////////////////////*/
// Magic
/*////////////////////////////////////////////////////////////////////////////*/


    /**
     * @param null $money
     * @param string $separatorDec
     * @param string $separatorTh
     * @param int $size
     */
    public function __construct
  (
      $money = null,
      $separatorDec = ',',
      $separatorTh = '.' ,
      $size = 2
  )
  {
    if (Log::$levelVerbose)
      Log::create($this);

    if ($money) {
      $this->setMoneyLanguage($money);
    }

    $this->separatorDec = $separatorDec;
    $this->separatorTh = $separatorTh;
    $this->size = $size;

  }//end public function __construct

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->formatToEnglish();

  }//end public function __toString */

/*////////////////////////////////////////////////////////////////////////////*/
// Singleton
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibFormatterMoney
   */
  public static function getInstance()
  {

    if (is_null(self::$instance)) {
      self::$instance = new LibFormatterMoney();
    }

    return self::$instance;

  }//end public static function getInstance */

 /**
   * @return LibFormatterMoney
   */
  public static function getActive()
  {

    if (is_null(self::$instance)) {
      self::$instance = new LibFormatterMoney();
    }

    return self::$instance;

  }//end public static function getActive */

/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $separatorDec
   * @param string $separatorTh
   * @param int $size
   */
  public function setFormat($separatorDec = ',', $separatorTh = '.' , $size = 2)
  {
    $this->separatorDec = $separatorDec;
    $this->separatorTh = $separatorTh;
    $this->size = $size;

  }//end public function setFormat

  /**
   * @param int $money
   */
  public function setMoneyLanguage($money)
  {
    $this->moneyLanguage = $money;
    $rawDec = explode($this->separatorDec , $money);

    $englishMoney = isset($rawDec[1]) ? '.'.$rawDec[1] : '';
    $englishMoney = str_replace($this->separatorTh , '' , $rawDec[0]).$englishMoney;

    $this->moneyEnglish = $englishMoney;

  }//end public function setMoneyLanguage

  /**
   *
   */
  public function setMoneyEnglish($englishMoney)
  {
    $this->moneyEnglish = $englishMoney;
  }//end public function setMoneyEnglish

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function formatToEnglish()
  {
    return $this->moneyEnglish;
  }//end public function formatToEnglish

  /**
   * @return float
   */
  public function formatToLanguage($money = null)
  {
    if (!$money) {
      $money = $this->moneyEnglish;
    }

    return number_format
    (
      $money ,
      $this->size,
      $this->separatorDec ,
      $this->separatorTh
    );

  }//end public function formatToLanguage

  /**
   * @param string $money
   */
  public static function format($money)
  {
    if (!self::$instance)
      self::getActive();

    return self::$instance->formatToLanguage($money);

  }//end public static function format */

} // end of LibFormatterMoney

