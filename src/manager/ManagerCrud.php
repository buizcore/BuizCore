<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
* @projectUrl  : http://buizcore.com
*
* @licence     : BuizCore.com internal only
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/


class ManagerCrud extends Manager
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/
    
    /**
     * @var null
     */
    public $domainKey = null;
    
    /**
     * Liste von feldern die verwendet werden sollen um auf unique zu checken
     * @var array
     */
    public $uniqueCheckFields = [];
    
    /**
     * @param array $dsetFields
     * @param array $fields
     * @param int $dsetId
     * @param array $checkExists
     * 
     * @return Entity
     */
    public function saveByArray($dsetFields, $fields = [], $dsetId = null, $checkExists = [])
    {
    
        $orm = $this->getOrm();

        if ($dsetId) {
            
            if (!is_array($dsetId)) {
                
                $dset = $orm->get($this->domainKey, $dsetId);
    
                if (!$dset) {
                    throw new Io_Exception('There is no Dataset with the id '.$dsetId );
                } 
                
            } else {
                

                $where = [];
                
                foreach ($dsetId as $key) {
                
                    if (!isset($dsetFields[$key])) {
                        $where[$key] = null;
                    } else {
                        $where[$key] = $dsetFields[$key];
                    }
                    
                }


                $dset = $orm->getWhere($this->domainKey, $where);
                
                if (!$dset) {
                    $dset = $orm->newEntity($this->domainKey);
                }
                
            }

        } else if($checkExists) {
            

            $where = [];
            
            foreach ($checkExists as $key => $value) {
                
                if(is_null($value)){
                    $where[] = " {$key} is null ";
                } else {
                    $where[] = " {$key} = '".$orm->escape($value)."' ";
                }
                
            }
            
            $dset = $orm->getWhere($this->domainKey, implode(' AND ',$where) );
            
            if (!$dset) {
                $dset = $orm->newEntity($this->domainKey);
            }
            
            
        } else {
      
            $dset = $orm->newEntity($this->domainKey);
        }
    
        $dset->addData($dsetFields);
    
        if ($dset->isNew()) {
            $this->setDefaultData($dset);
        }
    
        $orm->save($dset);
    
        return $dset;
    
    }//end public function saveByArray */

    /**
     * @param array $searchParams
     *
     * @return Entity
     */
    public function getBy($searchParams)
    {
    
        $orm = $this->getOrm();
        
        $where = [];
        
        foreach ($searchParams as $key => $value) {
            $where[] = " {$key} = '".$orm->escape($value)."' ";
        }
        
        return $orm->getWhere($this->domainKey, implode(' AND ',$where) );
    
    }//end public function getBy */
    

    /**
     * @param Context $struct
     * @param string $key
     * @param array | int $dsetId
     * @param Function $checkFunc
     * 
     * @return Entity
     */
    public function saveByStructure($struct, $key, $dsetId = null, $checkFunc = null)
    {
        
        $orm = $this->getOrm();
        
        if ($checkFunc && !$checkFunc($struct, $dsetId)) {
            Log::debug('checkFunc Param failed');
            return false;
        }

        if (!$this->saveByStructure_Check($struct, $dsetId)) {
            Log::debug('saveByStructure_Check failed');
            return false;
        }
        
        if (!$this->saveByStructure_Before($struct, $dsetId)) {
            Log::debug('saveByStructure_Before failed');
            return false;
        }
        
        if (isset($struct->data[$key])) {
            $dsetFields = $struct->data[$key];
        } else {
            $dsetFields = [];
        }
        
        
        if ($dsetId) {
            
            if (is_array($dsetId)) {
            
                $checkWhere = [];
            
                foreach($dsetId as $key){
                    $checkWhere[$key] = isset($dsetFields[$key])?$dsetFields[$key]:null;
                }
                $dset = $orm->getWhere($this->domainKey, $checkWhere);
                
                if (!$dset) {
                    $dset = $orm->newEntity($this->domainKey);
                }
            
            } else {
                $dset = $orm->get($this->domainKey, $dsetId);
                
                if (!$dset) {
                    throw new Io_Exception('There is no Dataset with the id '.$dsetId );
                }
            }
            
        } else {
            $dset = $orm->newEntity($this->domainKey);
        }
        
        $dset->addData($dsetFields);
        
        if ($dset->isNew()) {
            $this->setDefaultData($dset);
        }
        
        $orm->save($dset);
        
        $this->saveByStructure_After($struct, $dsetId);
        
        return $dset;
    
    }//end public function saveByStructure */
    
    /**
     * Checks vor dem speichern
     * 
     * @param Context $struct
     * @param int $dsetId
     *
     * @return Entity
     */
    protected function saveByStructure_Check($struct, $dsetId = null)
    {
        
        return true;
    
    }//end protected function saveByStructure_Check */

    /**
     * @param Context $struct
     * @param int $dsetId
     * 
     * @return Entity
     */
    protected function saveByStructure_Before($struct, $dsetId = null)
    {
        return true;
    }//end protected function saveByArray_Before */
    
    /**
     * @param Context $struct
     * @param int $dsetId
     * 
     * @return Entity
     */
    protected function saveByStructure_After($struct, $dsetId = null)
    {
        return true;
    }//end protected function saveByArray_After */
    
    
    /**
     * @param [Entity] $list
     * @param [key=>val] $defaults
     * @param array | int $dsetId
     * @param Function $checkFunc
     *
     * @return Entity
     */
    public function saveSaveMulti($list, $defaults = [],  $checkFunc = null)
    {
    
        $orm = $this->getOrm();
    
        if ($checkFunc && !$checkFunc($struct, $dsetId)) {
            Log::debug('checkFunc Param failed');
            return false;
        }
    
    
        return $dset;
    
    }//end public function saveByStructure */
    
    /**
     * Setzen der Default Daten
     * @param Entity $dset
     */
    public function setDefaultData($dset)
    {

    }//end public function setDefaultData */

}// end class CorePerson_Crud_Manager
