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
class LibFilereaderExcel extends LibFilereader
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var array
   */
  public $actual = [];

  /**
   *
   * @var array
   */
  public $pos = 0;

  /**
   *
   * @var string
   */
  public $delimiter = ';';

  /**
   *
   * @var string
   */
  public $enclosure = '"';

  /**
   *
   * @var string
   */
  public $escape = '\\';

/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $filename
   */
  public function load($filename)
  {

    if (!$this->resource = fopen($filename , 'r')) {
      throw new Io_Exception('failed to open csv resource: '.$filename);
    }

  }//end public function load */

  /**
   * (non-PHPdoc)
   * @see LibFilereader::close()
   */
  public function close()
  {
    if (is_resource($this->resource))
     fclose($this->resource);

  }//end public function close

/*////////////////////////////////////////////////////////////////////////////*/
// Interface: Iterator
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Iterator::current
   */
  public function current()
  {
    return $this->actual;
  }//end public function current */

  /**
   * @see Iterator::key
   */
  public function key()
  {
    return $this->pos;
  }//end public function key */

  /**
   * @see Iterator::next
   */
  public function next()
  {
    ++$this->pos;
    $this->actual = fgetcsv($this->resource, 0, $this->delimiter, $this->enclosure, $this->escape);

    return $this->actual;

  }//end public function next */

  /**
   * @see Iterator::rewind
   */
  public function rewind()
  {
    --$this->pos;
    fseek($this->resource, $this->pos);
    $this->actual = fgetcsv($this->resource, 0, $this->delimiter, $this->enclosure, $this->escape);

    return $this->actual;

  }//end public function rewind */

  /**
   * @see Iterator::valid
   */
  public function valid()
  {
    return $this->actual? true:false;

  }//end public function valid */

} // end class LibFilereaderExcel

