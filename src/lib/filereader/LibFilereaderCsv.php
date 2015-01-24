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
class LibFilereaderCsv extends LibFilereader
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
   * Position ab welcher gelesen werden soll
   * @var int
   */
  public $startPos = 0;

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
   * @param string $delimiter
   * @param string $enclosure
   */
  public function __construct($filename = null)
  {
      $this->filename = $filename;
      
  
      if ($filename)
          $this->load($filename);
  
  }//end public function __construct */
    
   /**
    * @param string $filename
    * @throws Io_Exception
    */
    public function open($filename)
    {
    
        if (!$this->resource = fopen($filename , 'r')) {
            throw new Io_Exception('failed to open csv resource: '.$filename);
        }
    
    }//end public function open */
    
    /**
     * @param string $filename
     */
    public function getFull($rowDel, $colDel)
    {
    
        $data = file_get_contents($this->filename);
        
        $rows = explode($rowDel, $data);
        
        $dataArray = [];
        
        foreach($rows as $row){
            $dataArray[] = explode($colDel, $row);
        }
        
        return $dataArray;
    
    }//end public function load */

    /**
    * @param string $filename
    */
    public function load($filename)
    {
    
        $this->open($filename);
    
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
  
  /**
   * Rückgabe der ersten Zeile
   */
  public function firstLine()
  {
        fseek($this->resource, 0);
        $data = $this->readLine();
        
        if ($this->pos)
            fseek($this->resource, $this->pos);
        
        return $data;
  
  }//end public function firstLine */

    /**
     * 
     */
    protected function readLine()
    {
        
        if (!$this->enclosure) {
            return explode($this->delimiter, fgets($this->resource)) ;
        } else {
            return fgetcsv($this->resource, 0, $this->delimiter, $this->enclosure, $this->escape);
        }
        
    }//end protected function readLine */

  
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
    $this->actual = $this->readLine();

    return $this->actual;

  }//end public function next */

  /**
   * @see Iterator::rewind
   */
  public function rewind()
  {
    --$this->pos;
    fseek($this->resource, $this->pos);
    $this->actual = $this->readLine();

    return $this->actual;

  }//end public function rewind */

  /**
   * @see Iterator::valid
   */
  public function valid()
  {
    return $this->actual? true:false;

  }//end public function valid */

} // end class LibFilesystemFile

