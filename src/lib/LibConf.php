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
 * Die Basis Klasse für die Konfigurationsklasse
 *
 */
class LibConf
{

    /**
    * @var TArray
    */
    public $status = null;
    
    /**
    * @var array
    */
    public $modules = null;
    
    /**
    * @var array
    */
    public $objids = [];
    
    /**
    * @var array
    */
    public $initClasses = [];
    
    /**
    * @var array
    */
    public $redirect = [];
    
    /**
    * speicher für maps aus conf/map
    * @var array
    */
    protected $maps = [];
    
    /**
    * @var array
    */
    protected $appConf = [];
    
    /**
    * @var array
    */
    protected $userSettings = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Constructor
/*////////////////////////////////////////////////////////////////////////////*/

   /**
    *
    */
    public function __construct()
    {
    
        $this->status = new TArray();
        $this->modules = new TArray();
        
        $this->load();
    
    }//end public function __construct */
    
    /**
     * @param string $key
     * @return string
     */
    public function __get($key)
    {
        return $this->status[$key];
    }//end public function __get */
    
    /**
     * @param string $key
     * @param string $value
     */
    public function __set($key, $value)
    {
        $this->status[$key] = $value;
    }//end public function __set */
    
    /**
     * @param string $key
     */
    public function __isset($key)
    {
        return (boolean)$this->status[$key];
    }//end public function __isset */

/*////////////////////////////////////////////////////////////////////////////*/
// getter + setter
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * @param string $key
    * @return int
    */
    public function getObjid($key)
    {
        return isset($this->objid[$key])
            ? $this->objid[$key]
            : null;
    
    }//end public function getObjid */

    /**
    * Getter für eine
    *
    * @param string $ext
    * @param string $sub
    * @return array
    */
    public function getConf($ext, $sub = null, $key = null)
    {

        if ($key)
            return isset($this->modules[$ext][$sub][$key])?$this->modules[$ext][$sub][$key]:null;
        else if ($sub)
          return isset($this->modules[$ext][$sub])?$this->modules[$ext][$sub]:null;
        else
          return isset($this->modules[$ext])?$this->modules[$ext]:null;
    
    }//end public function getConf */

    /**
    * Getter für eine die Konfiguration einer Resource
    *
    * @param string $ext
    * @param string $sub
    * @return array
    */
    public function getResource($ext, $sub = null)
    {
    
        if ($sub)
            return isset($this->modules[$ext][$sub])?$this->modules[$ext][$sub]:null;
        else
            return isset($this->modules[$ext])?$this->modules[$ext]:null;
    
    }//end public function getResource */

    /**
    *
    * @return array
    */
    public function getModules()
    {
        return $this->modules;
    }//end public function getModules */

    /**
    * @param string $key
    */
    public function getAppConf($key)
    {
        return isset($this->appConf[$key])?$this->appConf[$key]:null;
    }//end public function getAppConf */

    /**
    * @param string $key
    * @return string
    */
    public function getStatus($key)
    {
        return $this->status[$key];
    }//end public function getStatus */

    /**
    * Rückgabe eines Status Keys
    * @param string $key
    * @return string
    */
    public function getVal($key)
    {
        
        return $this->status[$key];
    
    }//end public function getVal */

    /**
    * @param $name
    */
    public function getMap($name)
    {
    
        if (isset($this->maps[$name]))
            return $this->maps[$name];
        
        $mapLocation = null;
        
        foreach (Conf::$confPath as $cPath) {
            if (file_exists($cPath.'map/'.$name.'.php')) {
                $mapLocation = $cPath.'map/'.$name.'.php' ;
                break;
            }
        }
        
        if (!$mapLocation) {
            $this->maps[$name] = [];
            return [];
        }
        
        // in map location is a var $map
        $map = null;
        include $mapLocation;
        
        $this->maps[$name] = $map;
        
        return $map;
    
    }//end public function getMap */

/*////////////////////////////////////////////////////////////////////////////*/
// load
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    */
    protected function load()
    {
    
        if (defined('CONF_KEY'))
            $confKey = CONF_KEY;
        else
            $confKey = 'web';
        
        if (file_exists(PATH_GW.'cache/conf/host/'.$confKey.'/conf.php')) {
        
            include PATH_GW.'cache/conf/host/'.$confKey.'/conf.php';
        
        } else {
        
            include PATH_GW.'conf/host/'.$confKey.'/conf.php';
        
            foreach (Conf::$confPath as $confPath) {
            
                if (file_exists($confPath.'host/'.$confKey.'/conf.php'))
                    include $confPath.'host/'.$confKey.'/conf.php';
            }
        
            $this->cache();
        
        }
    
    }//end protected function load */

    /**
    *
    * @todo implement the cache
    */
    protected function cache()
    {
    
    }//end protected function cache */

}//end abstract class LibConfAbstract

