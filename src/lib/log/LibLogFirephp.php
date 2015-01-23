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

include PATH_ROOT.'BuizCore_Vendor/vendor/FirePHPCore/FirePHP.class.php';

/**
 * @package net.webfrap
 */
class LibLogFirephp implements LibLogAdapter
{

  /**
   * @var FirePHP
   */
  private $firephp = null;

  /** default constructor
   */
  public function  __construct($conf)
  {
    $this->firephp = FirePHP::getInstance(true);

  }//end public function  __construct */

  /**
   * (non-PHPdoc)
   * @see src/i/ILogAppender#logline()
   */
  public function logline($time,  $level,  $file,  $line,  $message, $exception)
  {

    if (View::$blockHeader)
      return;

    if ( Log::level($level)  <= 32) {
      $this->firephp->fb("$time $level $file $line $message ", FirePHP::INFO);
    } else if (Log::level($level) == 64) {
      $this->firephp->fb("$time $level $file $line $message ", FirePHP::WARN);
    } else {
      $this->firephp->fb("$time $level $file $line $message ",FirePHP::ERROR);
    }

  } // end public function logline */

} // end class LibLogFirephp

