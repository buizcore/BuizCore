<?php
/*******************************************************************************
 *
 * @author      : Dominik Bonsch <dominik.bonsch@buiz.net>
 * @date        :
 * @copyright   : Buiz Developer Network <contact@buiz.net>
 * @project     : Buiz Web Frame Application
 * @projectUrl  : http://buiz.net
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
 *
 * @stateless bis auf Resource Objekte müssen Manager immer komplett Stateless sein
 * @staticFactory
 *
 */
class Manager extends BaseChild
{
/*////////////////////////////////////////////////////////////////////////////*/
// pool logic
/*////////////////////////////////////////////////////////////////////////////*/

   /**
    * @var [Manager] Diverse instantzen von Manager Klassen
    */
    private static $managers = [];
    
   /**
    * @var PBase
    */
    private static $defaultEnv = null;

   /**
    * @param PBase $env
    */
    public function __construct($env = null)
    {
    
        if(!$env){
            if(self::$defaultEnv){
            
                $env = self::$defaultEnv;
            } else {
            
                $env = BuizCore::$env;
            }
        }
        
        $this->env = $env;
        $this->init();
    
    } //end public function __construct */

    /**
    * @param PBase $env
    */
    public static function setDefaultEnv($env)
    {
    
        self::$defaultEnv = $env;
    
    }//end public static function setDefaultEnv */

   /**
    * @param string $className
    * @param string $key um eine custom environment instanz zu definieren
    * @return Manager
    */
    public static function get( $className, $key = null )
    {
    
        if (!$key)
          $key = $className;
        
        $className .= '_Manager';
        
        if (isset(self::$managers[$key])) {
            return self::$managers[$key];
        }
        
        if (!BuizCore::classLoadable($className)) {
            throw new ClassNotFound_Exception( 'There is no '.$className );
        }
        
        self::$managers[$key] = new $className( BuizCore::$env );
        
        return self::$managers[$key];
    
    }//end public static get */

   /**
    * leere init
    */
    protected function init()
    {
      
    }

}// end class Manager
