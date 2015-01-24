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
abstract class LibFilewriter
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  protected $filename;

  /**
   * @var string
   */
  protected $resource;

/*////////////////////////////////////////////////////////////////////////////*/
// comment
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $filename
   */
  public function __construct($filename = null)
  {
    $this->filename = $filename;

    if ($filename)
     $this->open($filename);

  }//end public function __construct */

  /**
   *
   */
  public function __destruct()
  {
    $this->close();
  }//end public function __destruct */

  /**
   *
   * @param string $filename
   */
  abstract public function open($filename);

  /**
   *
   * @param string $filename
   */
  abstract public function close();

} // end class LibFilereader

