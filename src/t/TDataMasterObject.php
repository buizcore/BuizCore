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
class TDataMasterObject
{

  /** Der Inhalt des Knotens
   */
  public $content = [];
  
  /** Der inhalt des Fallback Knotens
   * 
   * @var TDataObject
   */
  public $fallback = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Magic Functions
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TDataObject $fallback
   * @param [] $content
   */
  public function __construct($fallback, $content = [] )
  {

        $this->fallback = $fallback;
        $this->content = $content;

  } // end of member function __construct

  /**
   * Enter description here...
   *
   * @param string $key
   * @param unknown_type $value
   */
  public function __set($key , $value)
  {
    $this->content[$key] = $value;
  }// end of public function __set($key , $value)

    /**
    * Enter description here...
    *
    * @param string $key
    * @return string
    */
    public function __get($key)
    {
      
        if (isset($this->content[$key])) {
          return $this->content[$key];
        }
          
        return $this->fallback->getValue($key);
    
    }// end of public function __get($key)
    
    /**
    * Enter description here...
    *
    * @param string $key
    * @return string
    */
    public function __isset($key)
    {
      
        if (isset($this->content[$key])) {
          return true;
        }
      
        return $this->fallback->__isset($key);
    
    }// end of public function __isset */

/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param mixed $content
   */
  public function setData(array $content)
  {
    $this->content = $content;
  }//end public function setContent($content)

  /**
   * Enter description here...
   *
   * @param mixed $content
   */
  public function addData(array $content)
  {
    $this->content = array_merge($this->content ,  $content);
  }//end public function addContent($content)

  /**
   * Enter description here...
   *
   * @param string $key
   * @return mixed
   */
  public function getData($key, $fallback = null)
  {

      if (isset($this->content[$key])) {
          return $this->content[$key];
      } else {
          if (isset($this->fallback[$key])) {
              return $this->fallback->getData($key, $fallback);
          } else {
              return $fallback;
          }
      }
      
  }//end public function getData */

  /**
   * @param string $key
   * @param string $fallback
   * @return mixed
   */
  public function value($key, $fallback = null)
  {
      
    if (isset($this->content[$key])) {
      return $this->content[$key];
    } else {
        if (isset($this->fallback[$key])) {
          return $this->fallback->getData($key, $fallback);
        } else {
          return $fallback;
        }
    }

  }//end public function value */

  /**
   * @param string $key
   */
  public function getMoney($key, $fallback = null  )
  {

    if (isset($this->content[$key])) {
          return number_format($this->content[$key] , 2 , ',' , '.') ;
        } else {
        if (isset($this->fallback[$key])) {
          return $this->fallback->getMoney($key, $fallback);
        } else {
          return $fallback;
        }
    }

  } // end of member function getData

  /**
   * @param string $key
   */
  public function getHtml($key, $fallback = null   )
  {

    if (isset($this->content[$key])) {
      return html_entity_decode($this->content[$key]) ;
    } else {
        if (isset($this->fallback[$key])) {
          return html_entity_decode($this->fallback[$key]) ;
        } else {
          return $fallback;
        }
    }

  } // end public function getHtml */

  /**
   * @param string key
   */
  public function getNumeric($key, $fallback = null  )
  {

    if (isset($this->content[$key])) {
      return number_format($this->content[$key] , 2 , ',' , '.') ;
    } else {
        if (isset($this->fallback[$key])) {
          return number_format($this->fallback[$key] , 2 , ',' , '.') ;
        } else {
          return $fallback;
        }
    }

  } // end public function getNumeric */

  /**
   * @param string key
   */
  public function getChecked($key , $subkey = null)
  {

    if (isset($this->content[$key])) {
      if ($subkey) {
        if ($this->content[$key] == $subkey)
          return ' checked="checked" ';
      } else {
        if ($this->content[$key])
          return ' checked="checked" ';
      }
    }

    return '';

  } // end public function getChecked */

  /**
   * @param string $key
   */
  public function getDate($key , $format = 'd.m.Y', $fallback = null   )
  {

    if (isset($this->content[$key])) {
      return date($format , strtotime($this->content[$key])) ;
    } else {
        if (isset($this->fallback[$key])) {
          return date($format , strtotime($this->fallback[$key])) ;
        } else {
          return $fallback;
        }
    }

  }//end  public function getDate  */

  /**
   * @param string $key
   */
  public function getTime($key , $format = 'H:i:s', $fallback = null  )
  {

    if (isset($this->content[$key])) {
      return date($format , strtotime($this->content[$key])) ;
    } else {
        if (isset($this->fallback[$key])) {
          return date($format , strtotime($this->fallback[$key])) ;
        } else {
          return $fallback;
        }
    }

  }//end public function getTime  */

  /**
   * @param string $key
   */
  public function getTimestamp($key , $format = 'Y-m-d H:i:s', $fallback = null  )
  {

    if (isset($this->content[$key])) {
      return date($format , strtotime($this->content[$key])) ;
    } else {
        if (isset($this->fallback[$key])) {
          return date($format , strtotime($this->fallback[$key])) ;
        } else {
          return $fallback;
        }
    }

  }//end public function getTimestamp  */

  /**
   * @return void
   */
  public function reset()
  {
    $this->content = [];
    $this->fallback = [];
  }//end public function reset  */

} // end class TDataObject

