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
 *
 * @package net.webfrap
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class LibDbMysqlTransaction extends LibDbTransactions
{

    /**
     * Senden einer Datenbankabfrage zum erstellen eines Ausführplans
     *
     * @param string Name Name der Abfrage
     * @param string Der Fertige SQL Code
     * @return void
     * @throws LibDb_Exception
     */
    public function prepareSelect($name,  $sqlstring = null)
    {
    
        ++$this->counter ;
    
        if (is_object($name)) {
            $this->activObject = $name;
    
            if ( !$sqlstring = $this->activObject->getSql()) {
                if (!$sqlstring = $this->activObject->buildSelect()) {
                    // Fehlermeldung raus und gleich mal nen Trace laufen lassen
                    //$args = func_get_args();
                    throw new LibDb_Exception(I18n::s('wbf.log.dbFailedToParseSql'));
                }
            }
            $name = $this->activObject->getName();
    
        } elseif (trim($name) == '' or trim($sqlstring) == '') {
            // Fehlermeldung raus und gleich mal nen Trace laufen lassen
            //$args = func_get_args();
            throw new LibDb_Exception(I18n::s('wbf.log.dbIncopatibleParameters'));
        }
    
        if (Log::$levelDebug)
            Log::debug(__FILE__ , __LINE__ ,'Name: '.$name.' SQL: '.$sqlstring);
    
        if (!$this->result = $this->connection->prepare($sqlstring)) {
            throw new LibDb_Exception
            (
                I18n::s('wbf.log.dbNoResult',array($this->connection->error))
            );
        }
    
        $this->prepares[$name] = $this->result;
    
    } // end public function prepareSelect($name,  $sqlstring = null)
    
    /**
     * Ein Insert Statement an die Datenbank schicken
     *
     * @param res Sql Ein Aktion Object
     * @return int
     */
    public function prepareInsert($name,  $sqlstring = null)
    {
    
        ++$this->counter ;
    
        if (is_object($name)) {
            $this->activObject = $name;
    
            if ( !$sqlstring = $this->activObject->getSql()) {
                if (!$sqlstring = $this->activObject->buildInsert(true)) {
                    // Fehlermeldung raus und gleich mal nen Trace laufen lassen
                    $args = func_get_args();
                    throw new LibDb_Exception
                    (
                        I18n::s('wbf.log.dbFailedToParseSql')
                    );
                }
            }
            $name = $this->activObject->getName();
    
        } elseif (trim($name) == '' or trim($sqlstring) == '') {
            // Fehlermeldung raus und gleich mal nen Trace laufen lassen
            $args = func_get_args();
            throw new LibDb_Exception
            (
                I18n::s('wbf.log.dbIncopatibleParameters')
            );
        }
    
        if (Log::$levelDebug)
            Log::debug(__FILE__ , __LINE__ ,'Name: '.$name.' SQL: '.$sqlstring);
    
        if (!$this->result = $this->connection->prepare($sqlstring)) {
            throw new LibDb_Exception
            (
                I18n::s('wbf.log.dbNoResult',array($this->connection->error))
            );
        }
    
        $this->prepares[$name] = $this->result;
    
    } // end public function prepareInsert($name,  $sqlstring = null)
    
    /**
     * Ein Updatestatement an die Datenbank schicken
     *
     * @param res Sql Ein Aktion Object
     * @param boolean Send
     * @return int
     */
    public function prepareUpdate($name,  $sqlstring = null)
    {
    
        ++$this->counter ;
    
        if (is_object($name)) {
            $this->activObject = $name;
    
            if ( !$sqlstring = $this->activObject->getSql()) {
                if (!$sqlstring =$this->activObject->buildUpdate(true)) {
                    // Fehlermeldung raus und gleich mal nen Trace laufen lassen
                    throw new LibDb_Exception
                    (
                        I18n::s('wbf.log.dbFailedToParseSql')
                    );
                }
            }
            $name = $this->activObject->getName();
    
        } elseif (trim($name) == '' or trim($sqlstring) == '') {
            // Fehlermeldung raus und gleich mal nen Trace laufen lassen
            $args = func_get_args();
            throw new LibDb_Exception
            (
                I18n::s('wbf.log.dbIncopatibleParameters')
            );
        }
    
        if (Log::$levelDebug)
            Log::debug(__FILE__ , __LINE__ ,'Name: '.$name.' SQL: '.$sqlstring);
    
        if (!$this->result = $this->connection->prepare($sqlstring)) {
            throw new LibDb_Exception
            (
                I18n::s('wbf.log.dbNoResult',array($this->connection->error))
            );
        }
    
        $this->prepares[$name] = $this->result;
    
    } // end public function prepareUpdate($name,  $sqlstring = null)
    
    /**
     * Ein Deletestatement and die Datenbank schicken
     *
     * @param res Sql Ein Aktion Object
     * @return
     */
    public function prepareDelete($name,  $sqlstring = null  )
    {
    
        ++$this->counter ;
    
        if (is_object($name)) {
            $this->activObject = $name;
    
            if ( !$sqlstring = $this->activObject->getSql()) {
                if (!$sqlstring = $this->activObject->buildDelete()) {
                    // Fehlermeldung raus und gleich mal nen Trace laufen lassen
                    throw new LibDb_Exception
                    (
                        I18n::s('wbf.log.dbFailedToParseSql')
                    );
                }
            }
            $name = $this->activObject->getName();
    
        } elseif (trim($name) == '' or trim($sqlstring) == '') {
            // Fehlermeldung raus und gleich mal nen Trace laufen lassen
    
            throw new LibDb_Exception
            (
                I18n::s('wbf.log.dbIncopatibleParameters')
            );
        }
    
        if (Log::$levelDebug)
            Log::debug(__FILE__ , __LINE__ ,'Name: '.$name.' SQL: '.$sqlstring);
    
        if (!$this->result = $this->connection->prepare($sqlstring)) {
            throw new LibDb_Exception
            (
                I18n::s('wbf.log.dbNoResult',array($this->connection->error))
            );
        }
    
        $this->prepares[$name] = $this->result;
    
    } // end of member function delete
    
    /**
     * Löschen eines Ausführplans in der Datenbank
     *
     * @param string Name Name der Abfrage die gelöscht werden soll
     * @return void
     * @throws LibDb_Exception
     */
    public function deallocate($name)
    {
    
        if (isset($this->prepares[$name])) {
            unset($this->prepares[$name]);
        }
    
    } // end public function deallocate($name)
    
    /**
     * Ausführen einer Vorbereiteten Datenbankabfrage
     *
     * @param   string Name Name der Query in der Datenbank
     * @param   array Values Ein Array mit den Daten
     * @throws  LibDb_Exception
     */
    public function executeQuery($name,  $values = null, $returnIt = true, $single = false)
    {
    
    } // end public function executeQuery($name,  $values = null, $returnIt = true, $single = false)
    
    /**
     * Ausführen einer Vorbereiteten Datenbankabfrage
     *
     * @param   string Name Name der Query in der Datenbank
     * @param   array Values Ein Array mit den Daten
     * @throws  LibDb_Exception
     */
    public function executeAction($name,  $values = null, $getNewId = false)
    {
    
    } // end public function executeAction($name,  $values = null, $getNewId = false)
    
} //end class LibDbMysqlTransaction

