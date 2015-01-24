<?php
use Predis\Command\PubSubPublish;
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
 * @author Dominik Bonsch <dominik.bonsch@buiz.net>
 * @copyright Buiz Developer Network <contact@buiz.net>
 * @package net.buiz
 */
class EntitySyncNode extends Manager
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/
    
    /**
     * @var Entity
     */
    public $entity;
    
    /**
     * @var int
     */
    public $id = null;
    
    /**
     * @var array
     */
    public $_retrofit = [];

    /**
     * @var array
     */
    public $_values = [];
    
    /**
     * Ok alle 
     * @var array
     */
    public $checkExist = [];
    
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
     * @var string $key
     */
    public function sync($key) 
    {
        
        $orm = $this->getOrm();
        
        // wenn keine checks vorhanden sind, dann ist was falsch
        if (!$this->checkExist)
            throw new InternalError_Exception('Existence Check Values are empty');
        
        foreach ($checkExist as $checkKey => $checkData) {
            
        }

	}//end public function sync */
	
	
	/**
	 * @param string $key
	 * @param string $value
	 * @param boolean $empty
	 */
	public function retrofit($key, $value, $empty = false)
	{
	
	    $this->_retrofit[$key] = $value;
	
	} // end public function retrofit */
	
	/**
	 * @param string $key
	 * @return string
	 */
	public function __get($key)
	{
	
	    if (isset($this->_values[$key])) {
	        return $this->_values[$key];
	    }
	
	    if (isset($this->_retrofit[$key])) {
	        return $this->_retrofit[$key];
	    }
	    
	    return null;
	    
	
	} // end public function __get */
	
	/**
	 * @param string $key
	 * @param string $value
	 * @return void
	 */
	public function __set($key, $value)
	{
	    return $this->_values[$key] = $value;

	}// end public function __set */
	
	/**
	 * the to String Method
	 *
	 * @return string
	 */
	public function __toString()
	{
	
	    return ''.$this->id;
	
	} // end public function __toString */


}//end class EntitySyncNode

